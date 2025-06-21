<?php

namespace App\Traits;

use App\Models\SoStatusStep;
use Illuminate\Database\Eloquent\Factories\HasFactory;

trait SoStatusTrait
{
    use HasFactory, TenantableTrait, DatesModelTraits;


    /**
     * Relacionamento: Status possui muitos passos (steps).
     */
    public function statusSteps()
    {
        return $this->hasMany(SoStatusStep::class);
    }

    public static function bootSoStatusTrait()
    {
        static::deleting(function ($model) {
            $model->statusSteps()->delete();
        });
    }
}
