<?php

namespace App\Models;

use App\Traits\DatesModelTraits;
use App\Traits\TenantableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as OriginalRole;

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
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Role extends OriginalRole
{
    use DatesModelTraits, HasFactory, TenantableTrait;

    protected $table = 'roles';

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
        'created_at',
    ];

    protected $searchable = [
        'name',
        'description',
    ];

    public static function bootRole(): void
    {
        static::deleting(function ($model) {
            $permissions = $model->load('permissions');
            $model->revokePermissionTo($permissions);
        });
    }
}
