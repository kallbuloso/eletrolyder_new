<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tenant extends Model
{
  use HasFactory, HasRoles;

  protected $guarded = ['id'];

  protected $guard_name = 'web';

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'status', // active, inactive, blocked
    'blocking_reason',
  ];
}
