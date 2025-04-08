<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Factories\HasFactory;

trait CompanyTrait
{
    use HasFactory, PhoneableTrait, AddressableTrait, TenantebleTrait, SearchableTrait, DatesModelTraits;
}
