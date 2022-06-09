<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartado extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    } 

    public function productos(){
        return $this->belongsToMany(Product::class, 'apartado_product', 'apartado_id', 'product_id')->withPivot('precio');;
    }

    public function abonos(){
        return $this->hasMany(Abono::class);
    }

    
}
