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
     * @return array
     */
    public function rules()
    {
        return [
            'supplier_id' => 'required',
            'name' => 'required',
            'productId' => 'required',
            'minimum_stock' => 'required',
            'buy_price' => 'required',
            'sell_price' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4000',
        ];
    }
}
