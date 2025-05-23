<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Pratiksh\Imperium\Traits\HasPosition;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Pratiksh\Imperium\Traits\Role\ImplementsBreadAuthorization;

class Role extends Model
{
    use HasFactory, HasPosition, ImplementsBreadAuthorization, SoftDeletes;

    protected $guarded = [];

    protected $appends = ['bread_for_modules'];

    // Relationships
    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->withPivot('active', 'id')->withTimestamps();
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Accessors
    public function getBreadForModulesAttribute()
    {
        return $this->permissions->filter(function ($permission) {
            return in_array($permission->type, Permission::BREAD);
        })->groupBy(function ($permission) {
            return class_basename($permission->model);
        })->mapWithKeys(function ($permissions, $model) {
            return [
                $model => $permissions->mapWithKeys(function ($permission) {
                    return [$permission->type_label => [
                        'id' => $permission->id,
                        'type' => $permission->type,
                        'active' => $permission->pivot->active,
                        'pivot_id' => $permission->pivot->id,
                    ]];
                }),
            ];
        });
    }
}
