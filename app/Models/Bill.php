<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'shoppingCart_id',
        'total',
    ];

    //relacion con carrito de compras
    public function shoppingCarts():BelongsTo
    {
        return $this->belongsTo(ShoppingCart::class);
    }
}
