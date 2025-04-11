<?php

namespace App\Traits;

trait DatesModelTraits
{
    public function getEmailVerifiedAtAttribute($value)
    {
        return $this->checkDate($value);
    }

    public function getCreatedAtAttribute($value)
    {
        return $this->checkDate($value);;
    }

    public function getUpdatedAtAttribute($value)
    {
        return $this->checkDate($value);
    }

    public function getDeletedAtAttribute($value)
    {
        return $this->checkDate($value);
    }

    public function getLastPurchaseAttribute($value)
    {
        return $this->checkDate($value);
    }

    private function checkDate($value)
    {
        return $value ? date('d/m/Y', strtotime($value)) : null;
    }
}
