<?php

namespace App\Services\Generator\SchemaResource\SchemaRules;

use App\Contracts\Imperium\Generator\SchemaRuleInterface;
use App\Services\Generator\SchemaResource\SchemaSuppliers\MysqlSchemaSupplier;
use stdClass;
use Illuminate\Support\Str;

class MysqlSchemaRule implements SchemaRuleInterface
{
    public static array $minMaxDefault = [
        'tinyint' => [
            'unsigned' => ['min' => '0', 'max' => '255'],
            'signed' => ['min' => '-128', 'max' => '127'],
        ],
        'smallint' => [
            'unsigned' => ['min' => '0', 'max' => '65535'],
            'signed' => ['min' => '-32768', 'max' => '32767'],
        ],
        'mediumint' => [
            'unsigned' => ['min' => '0', 'max' => '16777215'],
            'signed' => ['min' => '-8388608', 'max' => '8388607'],
        ],
        'int' => [
            'unsigned' => ['min' => '0', 'max' => '4294967295'],
            'signed' => ['min' => '-2147483648', 'max' => '2147483647'],
        ],
        'bigint' => [
            'unsigned' => ['min' => '0', 'max' => '18446744073709551615'],
            'signed' => ['min' => '-9223372036854775808', 'max' => '9223372036854775807'],
        ],
    ];

    public string $table_name;

    public array $rules = [];

    public function __construct(string $table_name)
    {
        $this->table_name = $table_name;
    }

    public function rules(): array
    {
        $columns = (new MysqlSchemaSupplier($this->table_name))->columns();

        $rules = [];

        foreach ($columns as $column_name => $column) {
            if ($column->Key !== 'PRI' && $column_name !== 'deleted_at' && $column_name !== 'created_at' && $column_name !== 'updated_at') {
                $rules[$column_name] = $this->generateColumnRules($column);
            }
        }

        $this->rules = $rules;

        return $rules;
    }

    public function ruleForColumn(string $column_name): array
    {
        return [];
    }

    protected function generateColumnRules(stdClass $column): array
    {
        $relationRules = [];
        $relationRules[] = $column->Null === 'YES' ? 'nullable' : 'required';

        if (! empty($column->Foreign)) {
            $relationRules[] = 'exists:' . implode(',', $column->Foreign);
        }

        $type = Str::of($column->Type);
        $is_unsigned = false;
        $defined_rules = [];
        if ($type->contains('char')) {
            $defined_rules[] = 'max:' . filter_var($type, FILTER_SANITIZE_NUMBER_INT);
        } elseif ($type->contains('int')) {
            $is_unsigned = $type->contains('unsigned');
            $type = $type->before(' unsigned');
            $rule_type = $type->value;
            // prevent int(xx) for mysql
            $rule_type = preg_replace("/\([^)]+\)/", '', $type);

            if (! array_key_exists($rule_type, self::$minMaxDefault)) {
                $type = 'int';
            }
        } elseif ($type->contains('enum') || $type->contains('set')) {
            preg_match_all("/'([^']*)'/", $type, $matches);
            $columnRules[] = 'in:' . implode(',', $matches[1]);
        }
        if ($type->contains('char')) {
            $rule_type = 'char';
        } elseif ($type->contains('text')) {
            $rule_type = 'text';
        } elseif ($type->contains('enum')) {
            $rule_type = 'enum';
        } elseif ($type->contains('set')) {
            $rule_type = 'set';
        } elseif ($type->contains('double')) {
            $rule_type = 'double';
        } elseif ($type->contains('float')) {
            $rule_type = 'float';
        } elseif ($type->contains('decimal')) {
            $rule_type = 'decimal';
        } elseif ($type->contains('dec')) {
            $rule_type = 'dec';
        } elseif ($type->contains('year')) {
            $rule_type = 'year';
        } elseif ($type->contains('time')) {
            $rule_type = 'time';
        } elseif ($type->contains('timestamp')) {
            $rule_type = 'timestamp';
        } elseif ($type->contains('json')) {
            $rule_type = 'json';
        } else {
            $rule_type = 'default';
        }
        $rule_type = strtolower($rule_type);

        return $this->getRulesForColumn($rule_type, array_merge($relationRules, $defined_rules), $is_unsigned);
    }

    /*************  ✨ Codeium Command ⭐  *************/
    /**
     * Gets the rules for the given column type and merges them with the provided rules.
     *
     * If the column type is present in the $minMaxDefault array, it will also validate
     * and replace any 'min' or 'max' rules with the default values if they are invalid.
     *
     * @param string $column_type The column type to get the rules for.
     * @param array $rules The rules to merge with the default rules.
     * @param bool $is_unsigned Whether the column is unsigned.
     * @return array The merged rules.
     */
    /******  ca21a485-1a82-4b86-9bfd-a5a11be4e1ee  *******/
    public function getRulesForColumn(string $column_type, array $rules = [], bool $is_unsigned = false): array
    {
        $default_rules = config('imperium.schema.rules.' . trim($column_type) . '.default', []);
        // Merge the default rules and provided rules
        $merged_rules = array_merge($default_rules, $rules);



        if (isset(self::$minMaxDefault[$column_type][$is_unsigned ? 'unsigned' : 'signed'])) {
            // Get the min and max values for the column type from $minMaxDefault
            $minMaxValues = self::$minMaxDefault[$column_type][$is_unsigned ? 'unsigned' : 'signed'];
            // Initialize min and max variables
            $minValue = null;
            $maxValue = null;

            // Parse the rules to extract min and max values
            foreach ($merged_rules as $rule) {
                if (strpos($rule, 'min:') === 0) {
                    $minValue = explode(':', $rule)[1]; // Extract value after 'min:'
                } elseif (strpos($rule, 'max:') === 0) {
                    $maxValue = explode(':', $rule)[1]; // Extract value after 'max:'
                }
            }

            // Validate and replace 'min' rule
            if ($minValue !== null) {
                if ($minValue < $minMaxValues['min']) {
                    // Replace invalid min value with default
                    $merged_rules = array_filter($merged_rules, fn($rule) => strpos($rule, 'min:') !== 0);
                    $merged_rules[] = 'min:' . $minMaxValues['min'];
                }
            } else {
                // Add default min if missing
                $merged_rules[] = 'min:' . $minMaxValues['min'];
            }

            // Validate and replace 'max' rule
            if ($maxValue !== null) {
                if ($maxValue > $minMaxValues['max']) {
                    // Replace invalid max value with default
                    $merged_rules = array_filter($merged_rules, fn($rule) => strpos($rule, 'max:') !== 0);
                    $merged_rules[] = 'max:' . $minMaxValues['max'];
                }
            } else {
                // Add default max if missing
                $merged_rules[] = 'max:' . $minMaxValues['max'];
            }
        }

        return array_unique($merged_rules);
    }
}
