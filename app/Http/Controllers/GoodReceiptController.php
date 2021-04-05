<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{GoodReceipt, Order, Product, Status};

class GoodReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function approve(Request $request, $id) {
        try {
            $gr = GoodReceipt::findorfail($id);

            if($gr->status->id == 2) {
                \Alert::error('Error', 'Maaf Good Receipt sudah di approve');

                return redirect()->back();
            }

            \DB::transaction(function()use($id, $gr) {
                GoodReceipt::where('id', $id)->update([
                    'status_id' => 2,
                ]);

                foreach($gr->order->details as $detail) {
                    $qty = $detail->qty;
                    $product = $detail->product_id;

                    $product = Product::findorfail($product);
                    $current_stock = $product->stock;
                    $update_stock = $current_stock += $qty;

                    $product->update([
                        'stock' => $update_stock,
                    ]);
                }
            }); 
            
        } catch (\Exception $e) {
            \Alert::error('Error', $e->getMessage());

            return redirect()->back();
        }

        \Alert::success('Success', 'Berhasil meng-approve Good Receipt');

        return redirect()->back();
    }
}
