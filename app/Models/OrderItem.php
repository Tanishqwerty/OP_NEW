<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'user_id',
        'price',
        'quantity',
        'other_charges',
        'total_charges',
        'warehouse_id',
        'delivery_date',
        'shade_id',
        'size_id',
        'pattern_id',
        'embroidery_id'
    ];

    public function order()
    {
    return $this->belongsTo(Product::class);
    }
    public function orderItems()
{
    return $this->hasMany(OrderItem::class);
}
    public function shade() { return $this->belongsTo(Shade::class); }
    public function size() { return $this->belongsTo(Size::class); }
    public function pattern() { return $this->belongsTo(Pattern::class); }
    public function embroidery() { return $this->belongsTo(Embroidery::class); }
    public function product() { return $this->belongsTo(Product::class); }
    
    }
