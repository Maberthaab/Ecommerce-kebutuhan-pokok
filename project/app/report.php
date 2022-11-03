<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $dates = ['created_at'];

public function customer()
{
    return $this->belongsTo(Customer::class);
}



