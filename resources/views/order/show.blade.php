@extends('layouts.backend.master')

@section('title', 'Detail Order - '.$order->orderId)

@section('css')
  <!-- Datatable CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
@endsection

@section('content')
<div class="invoice">
  <div class="invoice-print">
    <div class="row">
      <div class="col-lg-12">
        <div class="invoice-title">
          <h2>Invoice</h2>
          <div class="invoice-number">Order {{ $order->orderId }}</div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-6">
            <address>
              <strong>Supplier</strong><br>
              {{ $order->supplier->name }}
            </address>
          </div>
          <div class="col-md-6 text-md-right">
            <address>
              <strong>Order ID</strong><br>
              {{ $order->orderId }}
            </address>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-6">
            <address>
              <strong>Status Order</strong><br>
              @if($order->status->id == 1)
                  <form action="{{ route('order.approve', $order->id) }}" method="POST" accept-charset="utf-8">
                      @csrf
                      @method('PATCH')
                      <input type="hidden" name="status_id" value="2"/>
                      <button type="submit" class="btn btn-sm btn-warning confirm-main" onclick="return confirm('Apakah anda ingin menyetujui order?')"> Pending </button>
                  </form>
              @elseif($order->status->id == 2) 
                  <form action="{{ route('order.approve', $order->id) }}" method="POST" accept-charset="utf-8">
                      @csrf
                      @method('PATCH')
                      <input type="hidden" name="status_id" value="1"/>
                      <button type="submit" class="btn btn-sm btn-success confirm-main" onclick="return confirm('Apakah anda ingin membatalkan penyetujuan order?')"> Approved </button>
                  </form>
              @endif
            </address>
          </div>
          <div class="col-md-6 text-md-right">
            <address>
              <strong>Order Date:</strong><br>
              {{ \Carbon\Carbon::parse($order->created_at)->format('d-M-Y H:m') }}<br><br>
            </address>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-md-12">
        <div class="section-title">Order Item</div>
        <p class="section-lead">All items here cannot be deleted.</p>
        <a class="btn btn-primary btn-sm btn-flat" data-toggle="collapse" href="#addItem" role="button" aria-expanded="false" aria-controls="addItem">Tambah Item</a>
        <hr>
        <div class="tab-content">
          <div class="collapse multi-collapse" id="addItem">
            <form role="form" method="post" action="{{ route('order.add-item', $order->id) }}">
              @csrf
              <div class="box-body">
                <div class="box-body">
                  <div class="form-group">
                    <label for="tag">Pilih Product</label>
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
                          @foreach($other_products as $key => $product)
                            <tr>
                              <td> {{ $key+1 }}</td>
                              <td> {{ $product->name }}</td>
                              <td> @currency($product->buy_price) </td>
                              <td>
                                <input type="hidden" name="product[]" value="{{ $product->id }}">
                                <input type="number" name="qty[]" class="form-control" value="0">
                                <input type="hidden" name="orderId" class="form-control" id="exampleInputEmail1" placeholder="Order Id" value="{{ $order->orderId }}" readonly>
                                <input type="hidden" name="supplier" class="form-control" value="{{ $product->supplier_id }}">
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
              </div>
            </form>
            <hr>
          </div>
        </div>
        <div class="table-responsive">
          <form action="{{ route('order.update-qty', $order->id) }}" method="POST" accept-charset="utf-8">
            @csrf
            @method('PATCH')
            <table class="table table-striped table-hover table-md">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th width="60">Action</th>
                    </tr>
                </thead>
                <?php 
                   $grand_total = 0;
                   $qty_total = 0;
                ?>
                <tbody>
                    @foreach($order->details as $key => $order_detail)
                    <?php 
                     $grand_total += $order_detail->grand_total;
                     $qty_total = $order_detail->qty;
                    ?>
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $order_detail->product->name }}</td>
                        @if($order->status->id == 1)
                        <td>
                          <input type="number" name="buy_price[]" class="form-control" value="{{ $order_detail->buy_price }}">
                        </td>
                        <td>
                          <input type="number" name="qty[]" class="form-control" value="{{ $order_detail->qty }}">
                          <input type="hidden" name="detail_id[]" class="form-control" value="{{ $order_detail->id }}">
                          <input type="hidden" name="products[]" class="form-control" value="{{ $order_detail->product_id }}">
                        </td>
                        @else 
                        <td> @currency($order_detail->buy_price) </td>
                        <td> {{ $order_detail->qty }} </td>
                        @endif
                        <td>@currency($order_detail->sub_total)</td>
                        <td>
                          <div style="width:40px">
                            <a class="btn btn-danger btn-flat btn-sm delete-detail-order" data-id="{{ $order_detail->id }}" data-action="{{ route('order.delete-item',$order_detail->id) }}"> 
                              <i class="fas fa-trash"></i>
                            </a>
                          </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-md-right">
              @if($order->status->id == 1)
                <button type="submit" class="btn btn-primary btn-icon icon-left">Update Qty</button>
              @endif
            </div>
          </form>
        </div>
        <br>
        <div class="row mt-12">
          <div class="col-lg-12 text-right">
            <!-- <div class="invoice-detail-item">
              <div class="invoice-detail-name">Subtotal</div>
              <div class="invoice-detail-value">1231</div>
            </div> -->
            <div class="invoice-detail-item">
              <div class="invoice-detail-name">Total Item</div>
              <div class="invoice-detail-value">{{ $qty_total }}</div>
            </div>
            <hr class="mt-2 mb-2">
            <div class="invoice-detail-item">
              <div class="invoice-detail-name">Grand Total</div>
              <div class="invoice-detail-value invoice-detail-value-lg">@currency($order->grand_total())</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <hr>
  <div class="text-md-right">
    <div class="float-lg-left mb-lg-0 mb-3">
      <!-- <button class="btn btn-primary btn-icon icon-left"><i class="fas fa-credit-card"></i> Process Payment</button>
      <button class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i> Cancel</button> -->
    </div>
    <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button>
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

  $(function() {
      $('#item').selectize();
  });

  $('body').on("click",".delete-detail-order",function(){
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