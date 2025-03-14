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
            'unsigned' => ['0', '255'],
            'signed' => ['-128', '127'],
        ],
        'smallint' => [
            'unsigned' => ['0', '65535'],
            'signed' => ['-32768', '32767'],
        ],
        'mediumint' => [
            'unsigned' => ['0', '16777215'],
            'signed' => ['-8388608', '8388607'],
        ],
        'int' => [
            'unsigned' => ['0', '4294967295'],
            'signed' => ['-2147483648', '2147483647'],
        ],
        'bigint' => [
            'unsigned' => ['0', '18446744073709551615'],
            'signed' => ['-9223372036854775808', '9223372036854775807'],
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
            $rules[$column_name] = $this->generateColumnRules($column);
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
        $columnRules = [];
        $columnRules[] = $column->Null === 'YES' ? 'nullable' : 'required';

        if (! empty($column->Foreign)) {
            $columnRules[] = 'exists:' . implode(',', $column->Foreign);

            return $columnRules;
        }

        $type = Str::of($column->Type);
        switch (true) {
            case $type == 'tinyint(1)' && config('imperium.schema.rules.tinyint.configurations.boolean', true):
                $columnRules[] = 'boolean';

                break;
            case $type->contains('char'):
                $columnRules[] = 'string';
                $columnRules[] = 'min:' . config('schema-rules.string_min_length');
                $columnRules[] = 'max:' . filter_var($type, FILTER_SANITIZE_NUMBER_INT);

                break;
            case $type == 'text':
                $columnRules[] = 'string';
                $columnRules[] = 'min:' . config('schema-rules.string_min_length');

                break;
            case $type->contains('int'):
                $columnRules[] = 'integer';
                $sign = ($type->contains('unsigned')) ? 'unsigned' : 'signed';
                $intType = $type->before(' unsigned')->__toString();

                // prevent int(xx) for mysql
                $intType = preg_replace("/\([^)]+\)/", '', $intType);

                if (! array_key_exists($intType, self::$integerTypes)) {
                    $intType = 'int';
                }

                $columnRules[] = 'min:' . self::$integerTypes[$intType][$sign][0];
                $columnRules[] = 'max:' . self::$integerTypes[$intType][$sign][1];

                break;
            case $type->contains('double') ||
                $type->contains('decimal') ||
                $type->contains('dec') ||
                $type->contains('float'):
                // should we do more specific here?
                // some kind of regex validation for double, double unsigned, double(8, 2), decimal etc...?
                $columnRules[] = 'numeric';

                break;
            case $type->contains('enum') || $type->contains('set'):
                preg_match_all("/'([^']*)'/", $type, $matches);
                $columnRules[] = 'string';
                $columnRules[] = 'in:' . implode(',', $matches[1]);

                break;
            case $type->contains('year'):
                $columnRules[] = 'integer';
                $columnRules[] = 'min:1901';
                $columnRules[] = 'max:2155';

                break;
            case $type == 'date' || $type == 'time':
                $columnRules[] = 'date';

                break;
            case $type == 'timestamp':
                // handle mysql "year 2038 problem"
                $columnRules[] = 'date';
                $columnRules[] = 'after_or_equal:1970-01-01 00:00:01';
                $columnRules[] = 'before_or_equal:2038-01-19 03:14:07';

                break;
            case $type == 'json':
                $columnRules[] = 'json';

                break;

            default:
                // I think we skip BINARY and BLOB for now
                break;
        }

        return $columnRules;
    }

    public function defaultRules(string $column_type, bool $is_unsigned, array $rules = []): array
    {
        $default_rules = config('schema.rules.' . trim($column_type) . 'default', []);

        // Merge the default rules and provided rules
        $merged_rules = array_merge($default_rules, $rules);

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

        return array_unique($merged_rules);
    }
}
