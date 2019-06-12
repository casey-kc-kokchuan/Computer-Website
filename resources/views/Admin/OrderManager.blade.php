@extends('Shared/AdminLayout')



@section('title', 'OrderManager')



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

	var orderTable = new Tabulator("#order-table",
	{
		layout: "fitDataFill",
		headerFilterPlaceholder: "Search",
		columns:
		[
			{title: "Order ID", field: "", headerFilter: true},
			{title: "Status", field:"", headerFilter: true},
			{title: "Order", field:"", headerFilter: true},
			{title: "Total Price", field:"", headerFilter: true},
			{title: "Name", field:"", headerFilter: true},
			{title: "Email", field:"", headerFilter: true},
			{title: "Contact No.", field:"", headerFilter: true},
			{title: "Address", field:"", headerFilter: true},
		]
	});

</script>
@endsection