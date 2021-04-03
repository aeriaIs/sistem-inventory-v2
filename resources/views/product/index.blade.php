@extends('layouts.backend.master')

@section('title', 'Data Product')

@section('css')
  <!-- Datatable CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
@endsection

@section('content')
<div class="col-12 col-md-12 col-lg-12">
  <div class="card">
    <div class="card-header">
      <a class="btn btn-primary" href="{{ route('product.create') }}">Tambah Product Baru</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
          <table class="table table-striped" id="myTable">
            <thead>
              <tr>
                  <th class="text-center">
                    #
                  </th>
                  <th>Supplier Name</th>
                  <th>Product Name</th>
                  <th>Kode</th>
                  <th>Stock</th>
                  <th>Buy Price</th>
                  <th>Sell Price</th>
                  <th style="width: 90px;">Action</th>
                </tr>
            </thead>
            <tbody>
              @foreach($products as $key => $product)
                <tr>
                  <td> {{ $key+=1 }} </td>
                  <td> {{ $product->supplier->name }} </td>
                  <td> {{ $product->name }} </td>
                  <td> {{ $product->productId }} </td>
                  <td> {{ $product->stock }} </td>
                  <td> @currency($product->buy_price) </td>
                  <td> @currency($product->sell_price) </td>
                  <td>
                    <a type="button" class="btn btn-secondary btn-sm" href="{{ route('product.show', $product->id) }}">
                      <i class="fas fa-eye"></i>
                    </a>
                    <a type="button" class="btn btn-primary btn-sm" href="{{ route('product.edit', $product->id) }}">
                      <i class="fas fa-edit"></i>
                    </a>
                    <button class="btn btn-danger btn-flat btn-sm delete-product" data-id="{{ $product->id }}" data-action="{{ route('product.destroy',$product->id) }}"> 
                      <i class="fas fa-trash"></i>
                    </button>
                  </td>
                </tr>
                @endforeach
            </tbody>
          </table>
      </div>
    </div>
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