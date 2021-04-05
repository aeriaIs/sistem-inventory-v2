@extends('layouts.backend.master')

@section('title', 'Buat Order')

@section('css')
  <!-- Datatable CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
@endsection

@section('content')
<div class="col-12 col-md-12 col-lg-12">
  <div class="card">
    <div class="card-header">
      <h4>Masukkan Data Product</h4>
    </div>
    <div class="card-body">
      <form role="form" method="post" action="{{ route('order.store') }}">
        @csrf
        <div class="box-body">
          <div class="box-body">
            <div class="form-group">
              <label for="exampleInputEmail1">Pilih Supplier</label>
              <select class="form-control" name="supplier">
                <option> Pilih Supplier </option>
                  @foreach($suppliers as $supplier)
                  <option value="{{ $supplier->id }}"
                    @if(isset($products))
                      @if($supplier->id == $supplierx->id)
                      selected
                      @endif
                    @endif
                  >{{ $supplier->name }}</option>
                  @endforeach
              </select>
            </div>
          </div>

          @if(isset($products))
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="exampleInputEmail1">Purchase Order Id</label>
                <input type="text" name="orderId" class="form-control" id="exampleInputEmail1" placeholder="Order Id" value="{{ $orderId }}" readonly>
              </div>
              <div class="table-responsive">
                <table class="table table-striped" id="myTable">
                  <thead>
                    <tr>
                      <th> # </th>
                      <th>Nama</th>
                      <th>Price</th>
                      <th>Quantity</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($products as $key => $product)
                    <tr>
                      <td> {{ $key+1 }}</td>
                      <td> {{ $product->name }}</td>
                      <td> @currency($product->buy_price) </td>
                      <td>
                        <input type="hidden" name="product[]" value="{{ $product->id }}">
                        <input type="number" name="qty[]" class="form-control" value="0">
                      </td> 
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="box-footer">
            <button type="submit" class="btn btn-primary btn-block">Submit</button>
          </div>
          @endif
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('js')
<script>
  $(document).ready( function () {
      $('#myTable').DataTable();
  } );
  
  $(document).ready(function(){

    $("select[name='supplier']").change(function(e) {
      let supplier_id = $(this).val();
      let url = "{{ url('/order/product') }}"+"/"+supplier_id;

      window.location.href = url;
    });

  })

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