<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salidas extends Model
{
    use HasFactory;

    protected $fillable = ['cantidad','precio','product_id'];

    public function producto(){
        return $this->belongsTo(Product::class);
    }
}
