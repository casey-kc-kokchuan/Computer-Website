@extends('Shared/PlainLayout')



@section('title', 'Verify Email')


@section('head')

@endsection



@section('body')


<div class="container">
	<div class="row justify-content-center">
		<div class="col-12 col-lg-8">
			<div class="card">
				<div class="card-header text-center">
					<h3>Order Placed</h3>
				</div>
				<div class="card-body text-center">
					<p>The order ID is <span id="id"></span>. Please verify your email.</p>
					<a href="{{ url('/')}}">Back to Shopping Cart</a>
				</div>
			</div>
		</div>
	</div>

</div>
@endsection



@section('script')

<script type="text/javascript">
	
	$( document ).ready(function()
	{
		let params = (new URL(document.location)).searchParams;
		document.getElementById("id").innerHTML = params.get("id");
	})

</script>


@endsection