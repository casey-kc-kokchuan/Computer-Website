@extends('Shared/CustomerLayout')



@section('title', 'Shopping Cart')



@section('head')


@endsection


<!--@change="sort($event)"-->
@section('body')

<div class="container" >
	<div class="row" id="shoppingCart">


		<div class="col-12" style="height:5%;">
			
			<label for="sortby">Sort By: </label>
			<select class="form-control" v-model="type" style="width:30%;display: inline-block;">
				<option value="">All</option>
				@foreach ($types as $type)
					<option value="{{$type->type}}">{{$type->type}}</option>
				@endforeach
			</select>
			<input type="text" v-model="name" placeholder="Search" class="form-control" style="width:40%;display: inline-block;">
			<button @click="search" type="button">Search</button>
		</div>

		<div class="col-12 col-lg-4 productList"  >
			
				
				<div v-for="(product, index) in productList" class="product" id="product">
					
					<p>@{{product.name}}</p>
					<img :src="product.img" style="width:100px;height:100px">
					<p>@{{product.price}}</p>


					<button @click="addToCart(index)">+</button>
					<button>About</button>
					
				</div>


			
		</div>

		<div class="col-12 col-lg-8 cartList">

			<div v-for="(cart, index) in cartList" class="cart" id="cart" >


				<p>@{{cart.name}}</p>
				<img :src="cart.img" style="width:100px;height:100px">
				<p>@{{cart.price}}</p>
				<p>Qty: @{{cart.qty}}</p>
				<button @click="removeFromCart(index)">-</button>

			</div>



		</div>


		
	</div>
</div>

@endsection



@section('script')

<script type="text/javascript">


var allList =
[
	{id: 1, name: "Logitech G502", img: "/img/g502.jpg", price: "500" },
	{id: 2, name: "Corsair Scimitar", img: "/img/scimitar.jpg", price: "420" },
	{id: 3, name: "Corsair K70", img: "/img/k70.jpg", price: "300" },
	{id: 4, name: "Razer Blackwidow", img: "/img/blackwidow.jpg", price: "600" }
];



var mouseList =
[
	{id: 1, name: "Logitech G502", img: "/img/g502.jpg", price: "500" },
	{id: 2, name: "Corsair Scimitar", img: "/img/scimitar.jpg", price: "420" }
];



var keyboardList = 
[
	{id: 3, name: "Corsair K70", img: "/img/k70.jpg", price: "300" },
	{id: 4, name: "Razer Blackwidow", img: "/img/blackwidow.jpg", price: "600" }
];
	


var shoppingCart = new Vue(
{
	el: "#shoppingCart",
	data: 
	{	
		productList: {!! json_encode($products) !!},
		cartList: [],
		type: "",
		name: "",
	},
	methods:
	{
		addToCart(index)
		{

			var obj = {};
			Object.assign(obj,this.productList[index])
			var	matchingIndex = this.cartList.findIndex(x => x.id == obj.id)

			if( matchingIndex == -1)
			{
				obj.qty = 1;
				this.cartList.push(obj)
			}
			else
			{
				this.cartList[matchingIndex].qty += 1;
			}
		},

		removeFromCart(index)
		{
			var obj = this.cartList[index];

			obj.qty -= 1;

			if(obj.qty <= 0)
			{
				this.cartList.splice(index, 1);
			}

		},

		search()
		{

			var url = "/Product/search?type=" + this.type + "&brand=&name=" + this.name;
			jsonAjax(url, "GET", "", function(response) {shoppingCart.productList = response;}, function() {alert("Server Error")});
		}
	}
})


</script>


@endsection