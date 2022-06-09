<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abono extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function apartado()
    {
        return $this->belongsTo(Apartado::class);
    }

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
