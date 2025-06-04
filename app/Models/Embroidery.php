<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Embroidery extends Model
{
    use HasFactory;
    
    protected $fillable = ['warehouse_id', 'embroidery_name', 'additional_cost', 'base_price' ,'status'];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

}
