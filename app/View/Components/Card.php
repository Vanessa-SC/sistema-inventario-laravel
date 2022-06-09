<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public $tipo;
    public $texto;
    public $color;
    public $cantidad;
    public $icon;

    public function __construct($texto,$icon, $tipo="otro", $color="blue", $cantidad=0)
    {
        $this->texto = $texto;
        $this->tipo = $tipo;
        $this->color = $color;
        $this->cantidad = $cantidad;
        $this->icon = $icon;
    }

    public function render()
    {
        return view('components.card');
    }
}
