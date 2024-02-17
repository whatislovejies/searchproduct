<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorites extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'product_id', 'product_name', 'price', 'store', 'date_added','comments'];
    public function favorites()
    {
        return $this->hasMany(Favorites::class);
    }
}
