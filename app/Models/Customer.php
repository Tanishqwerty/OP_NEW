<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
      use HasFactory;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'email',
    'mobile_number',
    'address',
    'city_id',
    'country',
    'postal',
    'is_active',
    'organization',
    'dob',
    'anniversary_date'
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'firstname',
    'lastname',
    'mobile_number',
    'password',
    'address',
    'city_id',
    'country',
    'postal',
  ];

   public function city()
   {
      return $this->belongsTo(City::class, 'city_id');
   }

}