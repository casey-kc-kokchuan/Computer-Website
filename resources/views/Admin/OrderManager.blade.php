@extends('Shared/AdminLayout')



@section('title', 'Order Manager')



@section('head')

@endsection



@section('body')

<div class="row order-manager-box">
	<div class="col-12 col-lg-11 order-manager">
		<div id="order-table"></div>
	</div>
</div>
@endsection



@section('script')

<script type="text/javascript">
	var data = {!! json_encode($Data) !!};
</script>
<script type="text/javascript" src={{ URL::asset('/js/OrderManager.js')}} /></script>
@endsection