<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    // Type
    const CUSTOM = 0;

    const BROWSE = 1;

    const READ = 2;

    const EDIT = 3;

    const ADD = 4;

    const DELETE = 5;

    const BREAD = [
        self::BROWSE,
        self::READ,
        self::EDIT,
        self::ADD,
        self::DELETE,
    ];

    const BREAD_LABELS = [
        self::BROWSE => 'Browse',
        self::READ => 'Read',
        self::EDIT => 'Edit',
        self::ADD => 'Add',
        self::DELETE => 'Delete',
    ];

    protected $guarded = [];

    protected $appends = ['type_label'];

    // Relationships
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withPivot('active')->withTimestamps();
    }

    // Accessors
    public function getTypeLabelAttribute()
    {
        return in_array($this->type, self::BREAD) ?
        self::BREAD_LABELS[$this->type]
        : 'Custom';
    }

    // Helper Functions
    public static function generateBREADForModel($model, Role $role, ?array $active_bread = null)
    {
        $exploded_model = explode('\\', $model);

        collect(self::BREAD)->each(function ($value) use ($model, $exploded_model, $role, $active_bread) {
            $permission = self::updateOrCreate([
                'name' => strtolower($exploded_model[count($exploded_model) - 1]).'_'.strtolower(self::BREAD_LABELS[$value]),
                'model' => $model,
                'type' => $value,
            ]);

            $role->permissions()->syncWithoutDetaching([$permission->id => ['active' => ! is_null($active_bread) ? in_array($value, $active_bread) : true]]);
        });

        return $role->permissions()->get();
    }
}
