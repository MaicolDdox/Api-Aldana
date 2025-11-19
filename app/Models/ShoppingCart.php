<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShoppingCart extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'book_id',
        'user_id',
        'precio',
    ];

    //Relacion con book
    public function book():BelongsTo
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    //Relacion con user
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
