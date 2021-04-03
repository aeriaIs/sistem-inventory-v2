@extends('layouts.backend.master')

@section('title', 'Edit Product')

@section('content')
<div class="col-12 col-md-12 col-lg-12">
  <div class="card">
    <div class="card-header">
      <h4>Edit Data Product</h4>
    </div>
    <div class="card-body">
      <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-group">
          <label for="exampleInputEmail1">Pilih Supplier</label>
          <select class="form-control" name="supplier_id">
              @foreach($suppliers as $supplier)
              <option value="{{ $supplier->id }}"
                @if($product->supplier_id == $supplier->id) 
                  selected
                @endif
              >{{ $supplier->name }}</option>
              @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="exampleInputEmail1">Nama Produk</label>
          <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Nama Produk" value="{{ $product->name }}">
        </div>

        <div class="form-group">
          <label for="exampleInputPassword1">Kode</label>
          <input type="text" name="productId" value="{{ $product->productId }}" class="form-control" id="exampleInputPassword1" placeholder="Kode Produk" readonly>
        </div>

        <div class="form-group">
          <label for="exampleInputEmail1">Minimum Stock</label>
          <input type="number" name="minimum_stock" class="form-control" id="exampleInputEmail1" placeholder="Minimum Stock" value="{{ $product->minimum_stock }}">
        </div>

        <div class="form-group">
          <label for="exampleInputEmail1">Stock</label>
          <input type="number" name="stock" class="form-control" id="exampleInputEmail1" placeholder="Stock" value="{{ $product->stock }}">
        </div>

        <div class="form-group">
          <label for="exampleInputEmail1">Harga Beli Produk</label>
          <input type="number" name="buy_price" class="form-control" id="exampleInputEmail1" placeholder="IDR  " value="{{ $product->buy_price }}">
        </div>

        <div class="form-group">
          <label for="exampleInputEmail1">Harga Jual Produk</label>
          <input type="number" name="sell_price" class="form-control" id="exampleInputEmail1" placeholder="IDR  " value="{{ $product->sell_price }}">
        </div>

        <div class="form-group">
          <div id="image-preview" class="image-preview float-left" style="margin-right: 20px;"> 
              <label for="image-upload" id="image-label">Choose File</label>
              <input type="file" name="image" id="image-upload" onchange="loadPreview(this);"/>
            </div>
            <div id="image-preview">
              <a href="#" class="thumbnail">
                <img id="preview_img" src="{{ asset('uploads/product-image/'.$product->image) }}" class="image-preview">
              </a>
            </div>
          </div>
        </div>
          
        <div class="box-footer">
          <button type="submit" class="btn btn-primary btn-block">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('js')
<script>
  function loadPreview(input, id) {
    id = id || '#preview_img';
    if (input.files && input.files[0]) {
        var reader = new FileReader();
 
        reader.onload = function (e) {
            $(id).attr('src', e.target.result).class('image-preview');
        };
 
        reader.readAsDataURL(input.files[0]);
    }
  }
</script>
@endsection