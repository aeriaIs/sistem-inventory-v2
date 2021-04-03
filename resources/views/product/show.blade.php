@extends('layouts.backend.master')

@section('title', 'Detail Product')

@section('content')
<div class="col-12 col-md-12 col-lg-12">
  <div class="card text-center">
    <div class="card-header">
      <h4>Detail - {{ $product->name }}</h4>
    </div>
    <div class="card-body">
      <div id="carouselExampleIndicators">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="justify-content-center w-50" src="{{ asset('uploads/product-image/'.$product->image) }}" alt="First slide" height="400">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="col-12 col-md-12 col-lg-12">
  <div class="table-responsive">
    <table class="table table-striped table-hover table-md">
      <tr>
          <th>Nama Supplier</th>
          <td> : </td>
          <td> {{ $product->supplier->name }} </td>

          <th>Nama Product</th>
          <td> : </td>
          <td> {{ $product->name }} </td>
      </tr>
      <tr>
          <th>Stock</th>
          <td> : </td>
          <td> {{ $product->stock }} </td>


          <th>Minimal Stock</th>
          <td> : </td>
          <td> {{ $product->minimum_stock }} </td>
      </tr>
          <th>Harga Beli</th>
          <td> : </td>
          <td> @currency($product->buy_price) </td>

          <th>Harga Jual</th>
          <td> : </td>
          <td> @currency($product->sell_price) </td>
      </tr>
      <tr>
          <th>Kode Produk</th>
          <td> : </td>
          <td> <b>{{ $product->productId }}</b> </td>

          <th> Barcode </th>
          <td> : </td>
          <td>
              {!! \DNS1D::getBarcodeHTML('4445645656', 'I25') !!}
          </td>
      </tr>
      <tr>
          <th>Didaftarkan Sejak </th>
          <td> : </td>
          <td> {{ \Carbon\Carbon::parse($product->created_at)->format('d-M-Y H:m') }} </td>

          <th>Terakhir Diubah</th>
          <td> : </td>
          <td> {{ \Carbon\Carbon::parse($product->updated_at)->format('d-M-Y H:m') }} </td>
      </tr>
    </table>
  </div>
</div>
@endsection

@section('js')
<script>
  $(document).ready( function () {
      $('#myTable').DataTable();
  } );

  $('body').on("click",".delete-product",function(){
      var current_object = $(this);
      swal({
          title: "Apakah anda Yakin?",
          text: "Data yang dihapus tidak akan bisa dikembalikan!",
          type: "warning",
          showCancelButton: true,
          dangerMode: true,
          cancelButtonClass: '#ffffff',
          confirmButtonColor: '#dc3545',
          confirmButtonText: 'Delete',
      },function (result) {
          if (result) {
              var action = current_object.attr('data-action');
              var token = jQuery('meta[name="csrf-token"]').attr('content');
              var id = current_object.attr('data-id');

              $('body').html("<form class='form-inline remove-form' method='post' action='"+action+"'></form>");
              $('body').find('.remove-form').append('<input name="_method" type="hidden" value="delete">');
              $('body').find('.remove-form').append('<input name="_token" type="hidden" value="'+token+'">');
              $('body').find('.remove-form').append('<input name="id" type="hidden" value="'+id+'">');
              $('body').find('.remove-form').submit();
          }
      });
  });
</script>
@endsection