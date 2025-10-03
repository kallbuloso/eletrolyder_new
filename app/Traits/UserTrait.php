<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

trait UserTrait
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use AddressableTrait, DatesModelTraits, HasFactory, HasRoles, Notifiable, PhoneableTrait, TenantableTrait;
}
