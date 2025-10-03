<?php

namespace App\Models;

use App\Traits\DatesModelTraits;
use App\Traits\PhoneableTrait;
use App\Traits\TenantableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Phone extends Model
{
    use DatesModelTraits, HasFactory, PhoneableTrait, TenantableTrait;

    protected $table = 'phones';

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
        'phone_has_whatsapp',
    ];

    public function phoneable()
    {
        return $this->morphTo();
    }
}
