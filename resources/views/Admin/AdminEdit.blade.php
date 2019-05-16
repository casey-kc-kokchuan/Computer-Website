@extends('Shared/AdminLayout')

@section('title', 'Admin')

@section('body')

<div class="row">
	<div class="col-md-12">
		<br />
		<h3>Edit Record</h3>
		<br />
		@if(count($errors) > 0)
		<div>
			<ul>
			@foreach($errors->all() as $error)
				<li>{{$error}}</li>
			@endforeach
			</ul>
		</div>
		@endif
		<form method="post" action="{{action('ProductController@update',$id)}}">
			{{csrf_field()}}
			<input type="hidden" name="_method" value="PATCH" />
			<div class="form-group">
				<input type="text" name="product_name" class="form-control" value="{{$product->product_name}}" placeholder="Enter Product Name" />
			</div>
			<div class="form-group">
				<input type="text" name="product_price" class="form-control" value="{{$product->product_price}}" placeholder="Enter Product Price" />
			</div>
			<div class="form-group">
				<select name="product_type">
					<option value="CPU">CPU</option>
					<option value="RAM">RAM</option>
					<option value="Motherboard">MotherBoard</option>
				</select>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-primary" value="Edit" />
			</div>
		</form>
	</div>
</div>

@endsection
