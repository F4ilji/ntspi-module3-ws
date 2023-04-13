<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = false;
    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity');
    }
    public function category() 
    {
        return $this->belongsTo(Category::class);
    }
    public function orderQuantity()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
