<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'amount',
        'type',
        'description',
        'date'
    ];

    // Ryšys: operacija priklauso vienai kategorijai
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Ryšys: operacija priklauso vartotojui
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}