<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\{Product, Supplier};
use Illuminate\Http\Request;
Use Alert;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::OrderBy('name', 'ASC')->get();

        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$productId = \Str::random(4).'-'.time().'-'.\Str::random(4);
        $suppliers = Supplier::orderBy('name', 'ASC')->get();

        return view('product.create', compact('suppliers', 'productId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/product-image/');
            $file->move($destinationPath, $filename);

            $data = Product::create([
                'supplier_id' => $request->supplier_id,
	            'name' => $request->name,
	            'slug'=> \Str::slug($request->name, '-'),
	            'productId' => $request->productId,
	            'minimum_stock' => $request->minimum_stock,
	            'stock' => 1,
	            'buy_price' => $request->buy_price,
	            'sell_price' => $request->sell_price,
	            'image' => $filename,
            ]);

        }else {
        	$data = Product::create([
                'supplier_id' => $request->supplier_id,
	            'name' => $request->name,
	            'slug'=> \Str::slug($request->name, '-'),
	            'productId' => $request->productId,
	            'minimum_stock' => $request->minimum_stock,
	            'stock' => 1,
	            'buy_price' => $request->buy_price,
	            'sell_price' => $request->sell_price,
            ]);
        }

    	Alert::success('Success', 'Berhasil menambahkan product baru.');

        return redirect(route('product.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $product = Product::findOrFail($product->id);

        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
