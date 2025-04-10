<?php

namespace App\Models;

use App\Traits\SupplierTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Supplier
 *
 * @property $id
 * @property $name
 * @property $nick_name
 * @property $contact
 * @property $person
 * @property $cpf_cnpj
 * @property $birth_date
 * @property $avatar
 * @property $site
 * @property $email
 * @property $note
 * @property $status
 * @property $blocking_reason
 * @property $last_purchase
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Supplier extends Model
{
    use SupplierTrait;

    protected $table = "suppliers";

    protected $perPage = 10;

    protected $guarded = ['id'];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'nick_name',
        'contact',
        'person',
        'cpf_cnpj',
        'birth_date',
        'avatar',
        'site',
        'email',
        'note',
        'status',
        'blocking_reason',
        'last_purchase'
    ];

    protected $searchable = [
        'name',
        'nick_name',
        'contact',
        'person',
        'cpf_cnpj',
        'birth_date',
        'avatar',
        'site',
        'email',
        'note',
        'status',
        'blocking_reason',
        'last_purchase'
    ];
}
