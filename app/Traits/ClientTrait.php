<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Factories\HasFactory;

trait ClientTrait
{
    use AddressableTrait, DatesModelTraits, HasFactory, PhoneableTrait, TenantableTrait;
}
