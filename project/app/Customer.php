<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $table = "Customers";
    protected $fillable = ['email'];
    public $timestamps = false;
}

public function getNameAttribute($value)
{
    return ucfirst($value);
}

public function order()
{
    return $this->hasMany(Order::class);
}