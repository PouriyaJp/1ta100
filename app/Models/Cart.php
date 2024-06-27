<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}
