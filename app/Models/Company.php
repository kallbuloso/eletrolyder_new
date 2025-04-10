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
 * @property $rg_insc_est
 * @property $ccm
 * @property $birth_date
 * @property $logo
 * @property $description
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
        'name',
        'fantasy_name',
        'contact_name',
        'person',
        'cpf_cnpj',
        'rg_insc_est',
        'ccm',
        'birth_date',
        'logo',
        'description',
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
        'rg_insc_est',
        'ccm',
        'birth_date',
        'logo',
        'description',
        'email',
        'website',
        'note'
    ];
}
