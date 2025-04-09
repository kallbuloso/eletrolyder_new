<?php

namespace App\Models;

use App\Traits\ClientTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Client
 *
 * @property $id
 * @property $tenant_id
 * @property $name
 * @property $nick_name
 * @property $person
 * @property $cpf_cnpj
 * @property $gender
 * @property $avatar
 * @property $note
 * @property $status
 * @property $blocking_reason
 * @property $last_purchase
 *
 * @property Tenant $tenant
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Client extends Model
{
    use ClientTrait;

    protected $table = "clients";

    protected $perPage = 10;

    protected $guarded = ['id'];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tenant_id',
        'name',
        'nick_name',
        'person',
        'cpf_cnpj',
        'gender',
        'avatar',
        'note',
        'status',
        'blocking_reason',
        'last_purchase'
    ];

    protected $searchable = [
        'name',
        'nick_name',
        'person',
        'cpf_cnpj',
        'gender',
        'avatar',
        'note',
        'status',
        'blocking_reason',
        'last_purchase'
    ];
}
