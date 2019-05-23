@extends('Shared/AdminLayout')

@section('title', 'Admin')

@section('body')
<div class="row">
	<div class="col-md-12">
		<br />
		<h3 aling="center">Add Data</h3>
		<br />
		@if(count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
			@foreach($errors->all() as $error)
				<li>{{$error}}</li>
			@endforeach
			</ul>
		</div>
		@endif
		@if(\Session::has('success'))
		<div class="alert alert-success">
			<p>{{ \Session::get('success') }}</p>
		</div>
		@endif

		<form method="post" action="{{url('Admin')}}">
			{{csrf_field()}}
			<div class="form-group">
				<select name="type">
					<option value="CPU">CPU</option>
					<option value="RAM">RAM</option>
					<option value="Keyboard">Keyboard</option>
					<option value="MotherBoard">MotherBoard</option>
				</select>
			</div>
			<div class="form-group">
				<input type="text" name="name" class="form-control" placeholder="Enter Product Name" />
			</div>
			<div class="form-group">
				<input type="text" name="price" class="form-control" placeholder="Enter Product Price" />
			</div>
			<div class="form-group">
				<input type="submit" class="btn	btn-primary" />
			</div>
		</form>
	</div>
</div>

@endsection

