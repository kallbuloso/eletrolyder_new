<?php

namespace App\Traits;

use App\Models\SoStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;

trait SoStatusStepTrait
{
    use DatesModelTraits, HasFactory, TenantableTrait;

    /**
     * Relacionamento: Status possui muitos passos (steps).
     */
    public function soStatus()
    {
        return $this->belongsTo(SoStatus::class, 'so_status_id', 'id');
    }
}
