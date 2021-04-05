<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use Illuminate\Http\Request;
use App\Models\{Product, Order, OrderDetail, Supplier, GoodReceipt};

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::withCount('details')->orderBy('created_at', 'desc')->get();

        return view('order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $orderId = 'PO-'.\Str::random(4).'-'.time();
        $suppliers = Supplier::orderBy('name', 'asc')->get();

        return view('order.create', compact('orderId', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        $product = $request->product;
        $qty = $request->qty;

        $order_id = Order::insertGetId([
            'orderId' => $request->orderId,
            'supplier_id' => $request->supplier,
            'status_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        foreach($qty as $key => $qt) {
            if($qt == 0) {
                continue;
            }

            $detail_product = Product::where('id', $product[$key])->first();
            $buy_price = $detail_product->buy_price;
            $sub_total = $buy_price * $qt;

            $po_detail = OrderDetail::insert([
                'order_id' => $order_id,
                'product_id' => $product[$key],
                'qty' => $qt,
                'buy_price' => $buy_price,
                'sub_total' => $sub_total,
                'created_at' => now(),
                'updated_at' => date('Y-m-d H:i:s')
            ]); 
        }

        \Alert::success('success', 'Berhasil membuat order.');

        return redirect(route('order.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);
        $supplier = Supplier::where('id', $order->supplier_id)->first();
        // $choosed_product = OrderDetail::where('order_id', $order->id)->get();
        $choosed_product = $order->details;

        foreach($choosed_product as $cp) {
            $the = $cp->product_id;
            $lol = explode(',', $cp);
            // dd($lol['2']);
            $other_products = Product::where('supplier_id', $supplier->id)->whereNotIn('id', [$the])->get();
        }

        // echo $other_products;
        // dd($other_products);

        return view('order.show', compact('order', 'supplier', 'other_products'));
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

    public function getProduct($supplier) {
        $orderId = 'PO-'.\Str::random(4).'-'.time();
        $suppliers = Supplier::orderBy('name', 'asc')->get();
        $supplierx = Supplier::where('id', $supplier)->first();
        $products = $supplierx->products;

        return view('order.create', compact('orderId', 'products', 'suppliers', 'supplierx'));
    }

     public function approve(Request $request, $id) {
        try {
            $po = Order::findorfail($id);

            if($request->status_id == 2) {
                $po->update([
                    'status_id' => 2
                ]);

                $receipt = GoodReceipt::insert([
                    'order_id' => $po->id,
                    'goodReceiptId' => \Str::random(5).'-'.time().'-'.\Str::random(4),
                    'status_id' => 1,
                    'created_at' => now(),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

            }else {
                $receipt = GoodReceipt::where('order_id', $po->id)->delete();

                $po->update([
                    'status_id' => 1
                ]);
            }

            \Alert::success('Success', 'Berhasil mengubah status Order.');

            return redirect()->back();
            
        } catch (\Exception $e) {
            \Alert::error('Error', $e->getMessage());

            return redirect()->back();
        }
    }

    public function deleteItem($id) {
        try {
            $po_detail = OrderDetail::where('id', $id)->first();
            $po_detail->delete();

            \Alert::success('Success', 'Item Berhasil dihapus dari daftar.');
        } catch (\Exception $e) {
            \Alert::error('Error', $e->getMessage());

        }

        return redirect()->back();
    }

    public function updateQty(Request $request, $id) {
        try {
            $quantity = $request->qty;
            $order_detail_id = $request->detail_id;
            $buy_price = $request->buy_price;
            $products = $request->products;

            foreach($quantity as $key => $qty) {
                $data['qty'] = $qty;
                $data['sub_total'] = $qty * $buy_price[$key];
                $data['buy_price'] = $buy_price[$key];
                $detail_id = $order_detail_id[$key];

                OrderDetail::where('id', $detail_id)->update($data);
                Product::where('id', $products[$key])->update([
                    'buy_price' => $data['buy_price'],
                ]);
            }

            \Alert::success('Success', 'Item Berhasil diperbarui..');
        } catch (\Exception $e) {
            \Alert::error('Error', $e->getMessage());

        }

        return redirect()->back();
    }

    public function addItem(OrderRequest $request, $id) {

        try {
            $product = $request->product;
            $qty = $request->qty;

            $order_id = Order::findorfail($id);

            foreach($qty as $key => $qt) {
                if($qt == 0) {
                    continue;
                }

                $detail_product = Product::where('id', $product[$key])->first();
                $buy_price = $detail_product->buy_price;
                $sub_total = $buy_price * $qt;

                $po_detail = OrderDetail::insert([
                    'order_id' => $order_id->id,
                    'product_id' => $product[$key],
                    'qty' => $qt,
                    'buy_price' => $buy_price,
                    'sub_total' => $sub_total,
                    'created_at' => now(),
                    'updated_at' => date('Y-m-d H:i:s')
                ]); 
            }

            \Alert::success('success', 'Berhasil menambah item order.');
            
        } catch (\Exception $e) {
            \Alert::error('Error', $e->getMessage());
        }

        return redirect()->back();
    }
}
