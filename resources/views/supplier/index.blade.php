@extends('layouts.backend.master')

@section('title', 'Data Supplier')

@section('content')
<div class="col-12 col-md-12 col-lg-12">
	<div class="card">
		<div class="card-header">
			<a class="btn btn-primary" data-toggle="collapse" href="#addSupplier" role="button" aria-expanded="false" aria-controls="addSupplier">Tambah Supplier Baru</a>
		</div>
		<div class="card-body">
			<div class="tab-content">
			    <div class="collapse multi-collapse" id="addSupplier">
			    	<form role="form" action="{{ route('supplier.store') }}" method="post">
				        @csrf
				        <div class="form-group">
				            <label>Nama Supplier</label>
				            <input name="name" type="text" class="form-control" placeholder="Name" value="{{ old('name') }}" required>
				        </div>
				        <div class="form-group">
				            <label>Alamat</label>
				            <input name="address" type="text" class="form-control" placeholder="Alamat" value="{{ old('address') }}" required>
				        </div>
				        <div class="form-group">
				            <label>Telepon</label>
				            <input name="phone" type="text" class="form-control" placeholder="Nomor Telepon" value="{{ old('phone') }}" required>
				        </div>
				        <input type="submit" class="btn btn-info" value="Save">
				        <input type="reset" class="btn btn-danger" value="Reset">
				    </form>
				<hr>
			    </div>
			</div>
			<div class="table-responsive">
			  	<table class="table table-striped" id="myTable">
				    <thead>
				     	<tr>
					        <th class="text-center">
					          #
					        </th>
					        <th>Supplier Name</th>
					        <th>Alamat</th>
					        <th>Telepon</th>
					        <th>Didaftarkan Sejak</th>
					        <th>Action</th>
				      	</tr>
				    </thead>
				    <tbody>
				    	@foreach($suppliers as $key => $supplier)
				      	<tr>
				       	 	<td> {{ $key+=1 }} </td>
					        <td> {{ $supplier->name }} </td>
					        <td> {{ $supplier->address }} </td>
					        <td> {{ $supplier->phone }} </td>
					        <td> {{ \Carbon\Carbon::parse($supplier->created_at)->format('d-M-Y H:m') }} </td>
					        <td>
					        	<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal{{ $supplier->id }}">
					        		<i class="fas fa-edit"></i>
								</button>
								<button class="btn btn-danger btn-flat btn-sm delete-supplier" data-id="{{ $supplier->id }}" data-action="{{ route('supplier.destroy',$supplier->id) }}"> 
									<i class="fas fa-trash"></i>
								</button>
					        </td>
				      	</tr>

				      	<div class="modal fade" id="exampleModal{{ $supplier->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">
						  <div class="modal-dialog" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h5 class="modal-title" id="exampleModalLabel">Edit Data {{ $supplier->name }} </h5>
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						          <span aria-hidden="true">&times;</span>
						        </button>
						      </div>
						      <div class="modal-body">
						        <form action="{{ route('supplier.update', $supplier->id) }}" method="post" accept-charset="utf-8" role="form">
									@csrf
									@method('PATCH')
									<div class="form-group">
										<label for=""></label>
										<input type="text" class="form-control" name="name" value="{{ $supplier->name }}">
									</div>
									<div class="form-group">
										<label for=""></label>
										<input type="text" class="form-control" name="address" value="{{ $supplier->address }}">
									</div>
									<div class="form-group">
										<label for=""></label>
										<input type="text" class="form-control" name="phone" value="{{ $supplier->phone }}">
									</div>
									<button type="submit" class="btn btn-primary">Simpan</button>
								</form>
						      </div>
						    </div>
						  </div>
						</div>
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

	$('body').on("click",".delete-supplier",function(){
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