<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $product = $this->route()->parameter('product');

        $rules = [
            'codigo' => 'required|unique:products',
            'descripcion' => 'required',
            'stock_inicial' => 'required',
            'precio_publico' => 'required',
            'precio_proveedor' => 'required',
            'file' => 'image'
        ];

        if($product){
            $rules['codigo'] = 'required|unique:products,codigo,'.$product->codigo;
        }

        return $rules;
    }
}
