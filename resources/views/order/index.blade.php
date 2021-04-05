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
      <a class="btn btn-primary" href="{{ route('product.create') }}">Buat Order Baru</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
          <table class="table table-striped" id="myTable">
            <thead>
              <tr>
                  <th class="text-center">
                    #
                  </th>
                  <th>Order id</th>
                  <th>Supplier</th>
                  <th>Total Product</th>
                  <th>Status</th>
                  <th>Grand Total</th>
                  <th>Dibuat Pada</th>
                  <th style="width: 90px;">Action</th>
                </tr>
            </thead>
            <tbody>
              @foreach($orders as $key => $order)
                <tr>
                  <td class="text-center"> {{ $key+=1 }} </td>
                  <td>{{ $order->orderId }}</td>
                  <td>{{ $order->supplier->name }}</td>
                  <td class="text-center">{{ $order->details->count() }}</td>
                  @if($order->status->id == 1)
                  <td>
                      <form action="{{ route('order.approve', $order->id) }}" method="POST" accept-charset="utf-8">
                          @csrf
                          @method('PATCH')
                          <input type="hidden" name="status_id" value="2"/>
                          <button type="submit" class="btn btn-sm btn-warning btn-block confirm-main" onclick="return confirm('Apakah anda ingin menyetujui order?')"> Pending </button>
                      </form>
                  </td>
                  @elseif($order->status->id == 2) 
                  <td>
                      <form action="{{ route('order.approve', $order->id) }}" method="POST" accept-charset="utf-8">
                          @csrf
                          @method('PATCH')
                          <input type="hidden" name="status_id" value="1"/>
                          <button type="submit" class="btn btn-sm btn-success btn-block confirm-main" onclick="return confirm('Apakah anda ingin membatalkan penyetujuan order?')"> Approved </button>
                      </form>
                  </td>
                  @endif
                  <td>@currency($order->grand_total())</td>
                  <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d-M-Y H:m') }}</td>
                  <td>
                    <a type="button" class="btn btn-secondary btn-sm" href="{{ route('order.show', $order->id) }}">
                      <i class="fas fa-eye"></i>
                    </a>
                    <a type="button" class="btn btn-primary btn-sm" href="{{ route('order.edit', $order->id) }}">
                      <i class="fas fa-edit"></i>
                    </a>
                    <button class="btn btn-danger btn-flat btn-sm delete-order" data-id="{{ $order->id }}" data-action="{{ route('order.destroy',$order->id) }}"> 
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

  $('body').on("click",".delete-order",function(){
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