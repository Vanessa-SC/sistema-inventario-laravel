<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Negocio extends Model
{
    protected $table = 'negocio';
    protected $fillable = [
        'nombre',
        'email',
        'direccion',
        'direccion2',
        'ciudad',
        'codigo_postal',
        'telefono',
        'telefono2'
    ];
    use HasFactory;

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
