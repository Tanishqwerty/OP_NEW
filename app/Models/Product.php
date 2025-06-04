<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        // 'warehouse_id',
        // 'pattern_id',
        // 'shade_id',
        // 'size_id',
        // 'embroidery_id',
        // 'is_embroidery',
        'name',
        'price',
        // 'embroidery_charges',
    ];
    public function warehouse() {
        return $this->belongsTo(Warehouse::class);
    }

    public function pattern() {
        return $this->belongsTo(Pattern::class);
    }

    public function shade() {
        return $this->belongsTo(Shade::class);
    }

    public function size() {
        return $this->belongsTo(Size::class);
    }

    public function embroidery() {
        return $this->belongsTo(Embroidery::class);
    }

}
