@extends('Shared/PlainLayout')



@section('title', 'Request Sent')


@section('head')

@endsection



@section('body')


<div class="container">
	<div class="row justify-content-center">
		<div class="col-12 col-lg-8">
			<div class="card">
				<div class="card-header text-center">
					<h3>Change Password Request Sent</h3>
				</div>
				<div class="card-body text-center">
					<p>Please verify your email.</p>
					<a href="{{ url('/Admin')}}">Back to Login Page</a>
				</div>
			</div>
		</div>
	</div>

</div>
@endsection



@section('script')



@endsection