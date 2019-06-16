@extends('Shared/PlainLayout')



@section('title', 'Order Confirmed')


@section('head')

@endsection



@section('body')


<div class="container">
	<div class="row justify-content-center">
		<div class="col-12 col-lg-8">
			<div class="card">
				<div class="card-header text-center">
					<h3>Order Confirmed</h3>
				</div>
				<div class="card-body text-center">
					<p>Please check email for order detail.</p>
					<a href="{{ url('/')}}">Back to Shopping Cart</a>
				</div>
			</div>
		</div>
	</div>

</div>
@endsection



@section('script')

@endsection