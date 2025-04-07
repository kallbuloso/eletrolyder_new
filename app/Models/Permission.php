<?php

namespace App\Models;

use App\Traits\SearchableTrait;
use Spatie\Permission\Models\Permission as OriginalPermission;

/**
 * Class Permission
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
class Permission extends OriginalPermission
{
    use SearchableTrait;

    protected $table = "permissions";

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tenant_id',
        'name',
        'description',
        'guard_name'
    ];

    protected $searchable = [
        'name'
    ];

    public function getCreatedAtAttribute($value)
    {
        return date("d/m/Y H:i:s", strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('d/m/Y H:i:s', strtotime($value));
    }

    public function getDeletedAtAttribute($value)
    {
        return date('d/m/Y H:i:s', strtotime($value));
    }
}
