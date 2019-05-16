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
		<table id="inventory_table" class="table table-bordered">
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
				<td><a class="btn btn-warning" href="{{action('ProductController@edit',$row['id'])}}">Edit</a></td>
				<td>
					<form method="post" class="delete_form" action="{{action('ProductController@destroy', $row['id'])}}">
						{{csrf_field()}}
						<input type="hidden" name="_method" value="DELETE">
						<button type="submit" class="btn btn-danger">Delete</button>
					</form>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
</div>
<script>
$(document).ready(function(){
	$('.delete_form').on('submit',function(){
		if(confirm("Are you sure you want to delete it?"))
		{
			return true;
		}
		{
			return false;
		}
	})
});
</script>
@endsection