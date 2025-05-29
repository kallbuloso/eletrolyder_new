<?php

namespace App\Models;

use App\Traits\CompanyTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Company
 *
 * @property $id
 * @property $name
 * @property $fantasy_name
 * @property $contact_name
 * @property $person
 * @property $cpf_cnpj
 * @property $rg_ie
 * @property $ccm_im
 * @property $birth_date
 * @property $logo
 * @property $email
 * @property $website
 * @property $note
 *
 * @property Tenant $tenant
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Company extends Model
{
    use CompanyTrait;

    protected $table = "companies";

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
        'fantasy_name',
        'contact_name',
        'person',
        'cpf_cnpj',
        'rg_ie',
        'ccm_im',
        'birth_date',
        'logo',
        'email',
        'website',
        'note'
    ];

    protected $searchable = [
        'name',
        'fantasy_name',
        'contact_name',
        'person',
        'cpf_cnpj',
        'rg_ie',
        'ccm_im',
        'birth_date',
        'logo',
        'email',
        'website',
        'note'
    ];
}
