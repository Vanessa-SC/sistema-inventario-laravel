<?php

namespace App\Http\Livewire;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = Product::where('codigo','like',"%$this->search%")->orwhere('descripcion','like',"%$this->search%")->paginate();
        return view('livewire.products-index', compact('products'));
    }
}
