@extends('Shared/AdminLayout')

@section('title', 'Admin')

@section('body')

<div class="row">
	<div class="col-md-12">
		<br />
		<h3 align="center">Inventory</h3>
		<br />
		@if($message = Session::get('success'))
			<div class="alert alert-success">
				<p>{{$message}}</p>
			</div>
		@endif
		<div align="right">
			<a href="{{route('Admin.create')}}" class="btn btn-primary">Add Data</a>
		<br />
		<br />
		</div>
		<table class="table table-bordered">
			<tr>
				<th>ID</th>
				<th>Product Name</th>
				<th>Product Type</th>
				<th>Product Price</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
			@foreach($product as $row)
			<tr>
				<td>{{$row['id']}}</td>
				<td>{{$row['product_name']}}</td>
				<td>{{$row['product_type']}}</td>
				<td>{{$row['product_price']}}</td>
				<td></td>
				<td></td>
			</tr>
			@endforeach
		</table>
	</div>
</div>

@endsection