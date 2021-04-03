@extends('layouts.backend.master')

@section('title', 'Tambah Product Baru')

@section('content')
<div class="col-12 col-md-12 col-lg-12">
  <div class="card">
    <div class="card-header">
      <h4>Masukkan Data Product</h4>
    </div>
    <div class="card-body">
      <form role="form" action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="box-body">

          <div class="form-group">
            <label for="exampleInputEmail1">Pilih Supplier</label>
            <select class="form-control" name="supplier_id">
                <option> Pilih Supplier </option>
                @foreach($suppliers as $supplier)
                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Nama Produk</label>
            <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Nama Produk">
          </div>

          <div class="form-group">
            <label for="exampleInputPassword1">Kode</label>
            <input type="text" name="productId" value="{{ $productId }}" class="form-control" id="exampleInputPassword1" placeholder="Kode Produk" readonly>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Minimum Stock</label>
            <input type="number" name="minimum_stock" class="form-control" id="exampleInputEmail1" placeholder="Minimum Stock">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Harga Beli Produk</label>
            <input type="number" name="buy_price" class="form-control" id="exampleInputEmail1" placeholder="IDR  ">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Harga Jual Produk</label>
            <input type="number" name="sell_price" class="form-control" id="exampleInputEmail1" placeholder="IDR  ">
          </div>

          <div class="form-group">
            <div id="image-preview" class="image-preview float-left" style="margin-right: 20px;"> 
                <label for="image-upload" id="image-label">Choose File</label>
                <input type="file" name="image" id="image-upload" onchange="loadPreview(this);"/>
              </div>
              <div id="image-preview">
                  <a href="#" class="thumbnail">
                    <img id="preview_img" src="https://www.w3adda.com/wp-content/uploads/2019/09/No_Image-128.png" class="image-preview">
                  </a>
              </div>
            </div>
          </div>

        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-primary btn-block">Buat</button>
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