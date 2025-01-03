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
        [
            self::BROWSE => 'Browse',
            self::READ => 'Read',
            self::EDIT => 'Edit',
            self::ADD => 'Add',
            self::DELETE => 'Delete',
        ][$this->type]
        : 'Custom';
    }

    // Helper Functions
    public static function generateBREADForModel($model, Role $role)
    {

        $exploded_model = explode('\\', $model);

        collect(self::BREAD)->each(function ($value, $name) use ($model, $exploded_model, $role) {
            $permission = self::updateOrCreate([
                'name' => strtolower($exploded_model[count($exploded_model) - 1]).'_'.$name,
                'model' => $model,
                'type' => $value,
            ]);

            $role->permissions()->syncWithoutDetaching($permission);
        });

        return $role->permissions()->get();
    }
}
