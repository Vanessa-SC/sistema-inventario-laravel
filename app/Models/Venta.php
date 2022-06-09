<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'folio',
        'cliente',
        'total',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    } 

    public function productos(){
        // return $this->belongsToMany(Product::class, 'venta_has_product', 'venta_id', 'product_id');
        return $this->belongsToMany('App\Models\Product')->withPivot('cantidad','precio');
    }
}
