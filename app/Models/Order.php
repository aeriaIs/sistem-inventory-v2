<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }
    
    public function product() {
    	return $this->belongsTo(Product::class);
    }

    public function status() {
    	return $this->belongsTo(Status::class);
    }

    public function details() {
    	return $this->hasMany(OrderDetail::class);
    }

    public function grand_total() {
    	$order = $this->id;

    	$grand_total = OrderDetail::where('order_id', $order)->sum('sub_total');

    	return $grand_total; 
    }
}
