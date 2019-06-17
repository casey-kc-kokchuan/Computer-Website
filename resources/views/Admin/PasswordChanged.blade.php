@extends('Shared/PlainLayout')



@section('title', 'Password Changed')


@section('head')

@endsection



@section('body')


<div class="container">
	<div class="row justify-content-center">
		<div class="col-12 col-lg-8">
			<div class="card">
				<div class="card-header text-center">
					<h3>Password Successfully Modified</h3>
				</div>
				<div class="card-body text-center">
					<a href="{{ url('/Admin')}}">Back to Login Page</a>
				</div>
			</div>
		</div>
	</div>

</div>
@endsection



@section('script')

@endsection