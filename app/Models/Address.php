<?php

namespace App\Models;

use App\Traits\SearchableTrait;
use App\Traits\TenantableTrait;
use App\Traits\AddressableTrait;
use App\Traits\DatesModelTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Address
 *
 * @property $id
 * @property $tenant_id
 * @property $type
 * @property $street
 * @property $number
 * @property $complement
 * @property $neighborhood
 * @property $city
 * @property $state
 * @property $country
 * @property $zip_code
 * @property $reference
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Address extends Model
{
    use HasFactory, DatesModelTraits, TenantableTrait, AddressableTrait;

    protected $table = "addresses";

    protected $perPage = 10;

    protected $guarded = ['id'];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tenant_id',
        'type',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'country',
        'zip_code',
        'reference'
    ];

    protected $searchable = [
        'type',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'country',
        'zip_code',
        'reference'
    ];

    public function addressable()
    {
        return $this->morphTo();
    }
}
