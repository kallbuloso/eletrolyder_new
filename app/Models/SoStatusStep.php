<?php

namespace App\Models;

use App\Traits\SoStatusStepTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SoStatusStep
 *
 * @property $id
 * @property $tenant_id
 * @property $so_status_id
 * @property $description
 * @property $created_at
 * @property $updated_at
 *
 * @property SoStatus $soStatus
 * @property Tenant $tenant
 * @property Main.serviceOrderHistory[] $main.serviceOrderHistories
 * @property Main.serviceOrder[] $main.serviceOrders
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class SoStatusStep extends Model
{
  use SoStatusStepTrait;

  protected $table = "so_status_steps";

  protected $perPage = 10;

  protected $guarded = ['id'];

  /**
    * Attributes that should be mass-assignable.
    *
    * @var array
    */
  protected $fillable = [
		'tenant_id', 
		'so_status_id', 
		'description'
  ];

  protected $searchable = [
		'tenant_id', 
		'so_status_id', 
		'description'
  ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function soStatus()
    {
        return $this->belongsTo(\App\Models\SoStatus::class, 'so_status_id', 'id');
    }
    
    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
    //  */
    // public function main.serviceOrderHistories()
    // {
    //     return $this->hasMany(\App\Models\Main.serviceOrderHistory::class, 'id', 'so_status_steps_id');
    // }
    
    // /**
    //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
    //  */
    // public function main.serviceOrders()
    // {
    //     return $this->hasMany(\App\Models\Main.serviceOrder::class, 'id', 'so_step_id');
    // }
    

}
