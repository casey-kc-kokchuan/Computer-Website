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
			<a href="{{route('create')}}" class="btn btn-primary">Add Data</a>
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
$(document).ready(function(){
	
})
</script>
@endsection