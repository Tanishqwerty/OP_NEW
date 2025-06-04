<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pattern extends Model
{
    protected $fillable = ['name', 'code', 'description', 'status', 'base_price', 'warehouse_id'];
}
