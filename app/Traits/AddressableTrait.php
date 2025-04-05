<?php

namespace App\Traits;

use App\Models\Address;

trait AddressableTrait
{
    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public static function bootAddressableTrait()
    {
        static::deleting(function ($model) {
            $model->addresses()->delete();
        });
    }
}
