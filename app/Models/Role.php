<?php

namespace App\Models;

use App\Traits\SearchableTrait;
use Spatie\Permission\Models\Role as OriginalRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Role
 *
 * @property $id
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
    use HasFactory, SearchableTrait;

    protected $table = "roles";

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
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
