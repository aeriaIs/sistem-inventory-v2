<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodReceipt extends Model
{
    protected $guarded = [];

    public function status() {
    	return $this->belongsTo(Status::class);
    }

    public function order() {
    	return $this->belongsTo(OrderDetail::class);
    }

    public function total_item() {
    	$order = $this->order;
    	$total = OrderDetail::where('order_id', $order->id)->count();

    	return $total;
    }
}
