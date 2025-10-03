<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Factories\HasFactory;

trait CompanyTrait
{
    use AddressableTrait, DatesModelTraits, HasFactory, PhoneableTrait, TenantableTrait;
}
