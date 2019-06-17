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


	var editIcon = function(cell, formatterParams, onRendered)
	{
		return '<i class="far fa-edit"></i>';

	}

	var orderTable = new Tabulator("#order-table",
	{
		layout: "fitDataFill",
		headerFilterPlaceholder: "Search",
		resizableColumns:false,
		data: {!! json_encode($Data) !!},
		columns:
		[
			{title: "Order ID", field: "id", headerFilter: true},
			{title: "Status", field:"status", headerFilter: true},
			{title: "Total Price(RM)", field:"total_price", headerFilter: true},
			{title: "Name", field:"name", headerFilter: true},
			{title: "Email", field:"email", headerFilter: true},
			{title: "Contact No.", field:"contact", headerFilter: true},
			{title: "Address", field:"address", headerFilter: true},
			{title: "Update Status", formatter: editIcon, align:"center", 
				cellClick(e,cell)
				{

					var orderlist = cell.getData().orderlist;
					var id = cell.getData().id;
					var options =   
					{
					    'Paid': 'Paid',
					    'Shipped': 'Shipped',
					    'Cancelled': 'Cancelled',
				    };


				    if(cell.getData().status == "Cancelled" || cell.getData().status == "Pending Confirmation")
				    {
				    	delete options.Paid ;
				    	delete options.Shipped ;
				    }

					(async function getStatus () 
					{
						const {value: status} = await Swal.fire(
						{
						  title: 'Update Order Status for Order ID: ' + id,
						  input: 'select',
						  inputOptions: options,
						  showCancelButton: true,
						})

						if (status) 
						{
						  var obj = {};
						  obj.status = status;
						  obj.id = id;
						  obj.orderlist = orderlist;

						  jsonAjax("/Order/UpdateOrderStatus", "POST", JSON.stringify(obj), function(response)
						  {
						  	if(response.Status == "Success")
						  	{
						  		SwalSuccess("Status is success fully updated.","");
						  		orderTable.setData(response.Data);
						  	}

						  	if(response.Status == "Database Error")
						  	{
						  		SwalError('Database Error. Please contact administrator.','');
						  	}

						  },alertError)
						}
					})()
					
				}	
			},
		],

		rowFormatter:function(row)
		{
		      var holderEl = document.createElement("div");
		      var tableEl = document.createElement("div");

		      holderEl.style.boxSizing = "border-box";
		      holderEl.style.padding = "10px 30px";
		      holderEl.style.borderTop = "1px solid rgba(34,36,38,.1)";
		      holderEl.style.background = "inherit";
		      holderEl.id = "nested";

		      // tableEl.style.boxSizing = "border-box";
		      tableEl.style.width = "60%";
		      tableEl.style.borderRadius = "1px solid #333";
		      tableEl.style.background = "inherit";

		      holderEl.appendChild(tableEl);

		      row.getElement().appendChild(holderEl);

		      var subTable = new Tabulator(tableEl, {
	      		  layout:"fitColumns",	
		          data:row.getData().orderlist,
		          columns:[
		          {title:"Name", field:"name"},
		          {title:"Quantity", field:"qty", align: "right"},
		          {title:"Unit Price(RM)", field:"price", align: "right"},
		          ]
		      })
		   },


	});

</script>
@endsection