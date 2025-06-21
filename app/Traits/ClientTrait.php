<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Factories\HasFactory;

trait ClientTrait
{
    use HasFactory, PhoneableTrait, AddressableTrait, TenantableTrait, DatesModelTraits;
}
