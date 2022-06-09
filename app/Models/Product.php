<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function entradas()
    {
        return $this->hasMany(Entradas::class);
    }

    public function salidas()
    {
        return $this->hasMany(Salidas::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function categoria()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    } 

    public function proveedor()
    {
        return $this->belongsTo('App\Models\Proveedore', 'proveedore_id');
    } 

    public function apartados(){
        return $this->belongsToMany(Apartado::class, 'apartado_has_product', 'product_id', 'apartado_id');
    }

    public function ventas(){
        // return $this->belongsToMany(Venta::class, 'venta_has_product', 'product_id', 'venta_id');
        return $this->belongsToMany('App\Models\Venta');

    }
}
