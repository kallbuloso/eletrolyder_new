<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Factories\HasFactory;

trait SupplierTrait
{
    use AddressableTrait, DatesModelTraits, HasFactory, PhoneableTrait, TenantableTrait;
    //
}
