<?php

namespace App\Http\Controllers;

Use Alert;
use Illuminate\Http\Request;
use App\Models\{Supplier, Product};
use App\Http\Requests\SupplierRequest;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::orderBy('created_at', 'ASC')->get();

        return view('supplier.index', compact('suppliers'));
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
    public function store(SupplierRequest $request)
    {
        $validated = $request->validated();

        $data = Supplier::create([
            'name' => $request->name,
            'slug' => \Str::slug($request->name, '-'),
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        Alert::success('Success', 'Berhasil menambahkan supplier baru.');

        return redirect()->back();
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
    public function update(SupplierRequest $request, $id)
    {
        $validation = $request->validated();

        $supplier = Supplier::findOrFail($id);

        $data = [
            'name' => $request->name,
            'slug' => \Str::slug($request->name, '-'),
            'address' => $request->address,
            'phone' => $request->phone,
        ];

        $supplier->update($data);

        Alert::success('Success', 'Berhasil mengubah data supplier..');

        return redirect(route('supplier.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        Alert::success('Success', 'Berhasil Menghapus data '.$supplier->name);

        return redirect(route('supplier.index'));
    }
}
