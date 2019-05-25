@extends('Shared/AdminLayout')



@section('title', 'Product Manager')



@section('head')

@endsection



@section('body')

<div class="container">
	<div class="row" id="productManager">
		


		<div class="col-12 col-md-4">
			
			<input type="text" v-model="name" placeholder="search"><button @click="search()">Search</button>
			<br><br>
			<button>Add item</button>
			<button><i class="fas fa-cog"></i></button>
			<br><br>
			<div class="nav nav-pills flex-column" id="v-pills-tab" role="tablist">
				
				<a class="nav-link active" id="pills-all-tab" data-toggle="pill"  aria-controls="pills-all" aria-selected="true" href="#" @click="typeSearch('')">All</a>

				<a v-for="type in types" class="nav-link" :id="'pills-all-' + type.type" data-toggle="pill" role="tab" :aria-controls="'pills-'+ type.type" aria-selected="false" href="#" @click="typeSearch(type)">@{{type.type}}</a>


			</div>
		</div>
		<div class="col-12 col-md-8">
			
			<div class="productManagerList">
				<div v-for="(product, index) in productList" class="product" id="product">
					
					<p>@{{product.name}}</p>
					<img :src="product.img" style="width:100px;height:100px">
					<p>@{{product.price}}</p>


					<button @click="edit(index)">Edit</button>
					
				</div>
			</div>


		</div>

	</div>

</div>


@endsection



@section('script')

<script type="text/javascript">
	
var productManager = new Vue(
{
	el: "#productManager",
	data :
	{
		productList:{!! json_encode($products) !!},
		types: {!! json_encode($types) !!},
		name:'',
		type: '',
	},
	methods:
	{
		search()
		{
			var url = "/Product/search?type=" + this.typeValue + "&brand=&name=" + this.name;
			jsonAjax(url, "GET", "", function(response) {this.productList = response;}, function() {alert("Server Error")});
		},

		typeSearch(type)
		{
			this.type = type;
			var url = "/Product/search?type=" + this.type + "&brand=&name=";

			jsonAjax(url, "GET", "", function(response) {this.productList = response;}, function() {alert("Server Error")});
		}
	}

})

</script>
@endsection