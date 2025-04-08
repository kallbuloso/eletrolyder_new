<?php

namespace App\Models;

use App\Traits\SearchableTrait;
use App\Traits\TenantebleTrait;
use App\Traits\DatesModelTraits;
use Spatie\Permission\Models\Role as OriginalRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Role
 *
 * @property $id
 * @property $tenant_id
 * @property $name
 * @property $description
 * @property $guard_name
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Role extends OriginalRole
{
    use HasFactory, SearchableTrait, TenantebleTrait, DatesModelTraits;

    protected $table = "roles";

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tenant_id',
        'name',
        'description',
        'guard_name',
        'updated_at',
        'created_at'
    ];

    protected $searchable = [
        'name',
        'description'
    ];

    public static function bootRole(): void
    {
        static::deleting(function ($model) {
            $permissions = $model->load('permissions');
            $model->revokePermissionTo($permissions);
        });
    }
}
