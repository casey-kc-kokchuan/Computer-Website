@extends('Shared/AdminLayout')

@section('title', 'Admin')

@section('body')

<h1>AdminPage</h1>
<div class="row">
	<div class="col-md-12">
		<a href="{{url('Admin/create')}}" class="btn btn-primary">Add Data</a>
	</div>
</div>

@endsection

