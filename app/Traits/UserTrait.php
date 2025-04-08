<?php

namespace App\Traits;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

trait UserTrait
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, PhoneableTrait, AddressableTrait, TenantebleTrait, SearchableTrait, DatesModelTraits, Notifiable;
}
