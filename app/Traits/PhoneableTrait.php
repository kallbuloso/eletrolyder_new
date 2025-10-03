<?php

namespace App\Traits;

use App\Models\Phone;

trait PhoneableTrait
{
    public function phones()
    {
        return $this->morphMany(Phone::class, 'phoneable');
    }

    public static function bootPhoneableTrait()
    {
        static::deleting(function ($model) {
            $model->phones()->delete();
        });
    }
}
