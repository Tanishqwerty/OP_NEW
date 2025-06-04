<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
   protected $fillable = ['city_name', 'delivery_charge', 'status'];
}
