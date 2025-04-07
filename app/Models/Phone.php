<?php

namespace App\Models;

use App\Traits\PhoneableTrait;
use App\Traits\SearchableTrait;
use App\Traits\TenantebleTrait;
use App\Traits\DatesModelTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Phone
 *
 * @property $id
 * @property $tenant_id
 * @property $phone_type
 * @property $phone_number
 * @property $phone_contact
 * @property $phone_has_whatsapp
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Phone extends Model
{
    use HasFactory, SearchableTrait, DatesModelTraits, TenantebleTrait, PhoneableTrait;

    protected $table = "phones";

    protected $perPage = 10;

    protected $guarded = ['id'];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tenant_id',
        'phone_type',
        'phone_number',
        'phone_contact',
        'phone_has_whatsapp',
    ];

    protected $searchable = [
        'phone_type',
        'phone_number',
        'phone_contact',
        'phone_has_whatsapp'
    ];

    public function phoneable()
    {
        return $this->morphTo();
    }
}
