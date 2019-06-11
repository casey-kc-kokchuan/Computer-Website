@extends('Shared/CustomerLayout')



@section('title', 'Shopping Cart')



@section('head')


@endsection



@section('body')

<div class="container-fluid">
	<div class="row no-gutters" id="shoppingCart">


		<div class="col-12 col-lg-2 max-height">

			<label>Name</label>
			<input type="text" v-model="searchName" placeholder="Search" class="form-control">
			<label>Type</label>
			<select class="form-control" v-model="searchType">
				<option value="">All</option>
				@foreach ($types as $type)
					<option value="{{$type->type}}">{{$type->type}}</option>
				@endforeach
			</select>
			<label>Brand</label>
			<select class="form-control" v-model="searchBrand">
				<option value="">All</option>
				@foreach ($brands as $brand)
					<option value="{{$brand->brand}}">{{$brand->brand}}</option>
				@endforeach
			</select>

			
			<button @click="search" type="button" class="btn-yellow btn-size-form">Search</button>
		</div>

		<div class="col-12 col-lg-5 product-list max-height">
			
				
				<div v-for="(product, index) in productList" class="product" id="product">
					
					<p><strong>@{{product.name}}</strong></p>
					<img :src="product.img" style="width:150px;height:100px">
					<p>RM&nbsp;@{{ formatPrice(product.price) 	}}</p>
					<p style="font-size:0.8em">@{{product.qty}} <i>in stock</i></p>


					<button @click="addToCart(index)">+</button>
					<button >About</button>
					
				</div>





			
		</div>

		<div class="col-12 col-lg-5 max-height">

			<div class="cart-list">
				<div v-for="(cart, index) in cartList" class="cart" id="cart" >
					<p><strong>@{{cart.name}}</strong></p>
					<img :src="cart.img" style="width:150px;height:100px">
					<p>RM&nbsp;@{{ formatPrice(cart.price)}}</p>
					<p>Qty: @{{cart.qty}}</p>
					<button @click="removeFromCart(index)">-</button>

				</div>
			</div>

			<div class="order-box">
				<p class="float-left">Total: RM @{{ formatPrice(total_price) }}</p>
				<button class="float-right" onclick="toggleOverlay('#place-order-overlay')">Place Order</button>
			</div>


		</div>


		
	</div>
</div>

<div id="place-order-overlay">
	<div id="place-order">
		<form @submit.prevent="handleSubmit">
			<div class="form-group">
				<label>Name</label>
				<input type="text" class="form-control" v-model="orderDetail.name">
			</div>
			<div class="form-group">
				<label>Email</label>
				<input type="text" class="form-control" v-model="orderDetail.email">
			</div>
			<div class="form-group">
				<label>Contact</label>
				<input type="text" class="form-control" v-model="orderDetail.contact">
			</div>
			<div class="form-group">
				<label>Address</label>
				<input type="text" class="form-control" v-model="orderDetail.address">
			</div>

			<button>Submit</button>
			<button onclick="toggleOverlay('#place-order-overlay')" type="button">Close</button>
		</form>
	</div>
</div>

@endsection



@section('script')

<script type="text/javascript">

$(document).ready(function()
{
	 // $(".product-list").mCustomScrollbar({
	 //     theme: "dark",
	 //     scrollButtons:{ enable: true },
	 //     axis : "yx",
	 //     advanced:{autoExpandHorizontalScroll:true}, 
  //     callbacks:{
  //       onOverflowY:function(){
  //         var opt=$(this).data("mCS").opt;
  //         if(opt.mouseWheel.axis!=="y") opt.mouseWheel.axis="y";
  //       },
  //       onOverflowX:function(){
  //         var opt=$(this).data("mCS").opt;
  //         if(opt.mouseWheel.axis!=="x") opt.mouseWheel.axis="x";
  //       },
  //   }
	 // });

	 // 	 $(".cart-list").mCustomScrollbar({
	 // 	     theme: "dark",
	 // 	     scrollButtons:{ enable: true },
	 // 	     axis : "y",
	 // 	     advanced:{autoExpandHorizontalScroll:true}, 
	 //       callbacks:{
	 //         onOverflowY:function(){
	 //           var opt=$(this).data("mCS").opt;
	 //           if(opt.mouseWheel.axis!=="y") opt.mouseWheel.axis="y";
	 //         },
	 //         onOverflowX:function(){
	 //           var opt=$(this).data("mCS").opt;
	 //           if(opt.mouseWheel.axis!=="x") opt.mouseWheel.axis="x";
	 //         },
	 //     }
	 // 	 });
});

var shoppingCart = new Vue(
{
	el: "#shoppingCart",
	data: 
	{	
		productList: {!! json_encode($products) !!},
		cartList: [],
		searchType: "",
		searchName: "",
		searchBrand: "",
		total_price: 0.00,
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
			
			this.total_price += this.productList[index].price;
		},

		removeFromCart(index)
		{
			var obj = this.cartList[index];

			obj.qty -= 1;

			this.total_price -= this.cartList[index].price;

			if(obj.qty <= 0)
			{
				this.cartList.splice(index, 1);
			}

		},

		search()
		{

			var url = "/Product/search?type=" + this.searchType + "&brand="+ this.searchBrand + "&name=" + this.searchName;
			jsonAjax(url, "GET", "", function(response) {shoppingCart.productList = response;}, alertError);
		},

		formatPrice(value) 
		{
	       return val = (value).toFixed(2);	
	    }
	}
})

var orderDetail = new Vue(
{
	el: "#place-order",
	data: 
	{
		orderDetail: 
		{
			name: "",
			email: "",
			contact: "",
			address: ""
		}
	},
	methods:
	{
		handleSubmit(event)
		{
			var obj = {};
			Object.assign(obj, this.orderDetail);
			obj.cart = shoppingCart.cartList;
			obj.total_price = shoppingCart.formatPrice(shoppingCart.total_price);

			alert(JSON.stringify(obj))

			// jsonAjax("/Order/PlaceOrder", "POST", "",function(response)
			// 	{
			// 		if(response.Status == "Success")
			// 		{

			// 		}

			// 		if(response.Status == "Database Error")
			// 		{

			// 		}

			// 		if(response.Status == "Quantity Error")
			// 		{

			// 		}

			// 	}, alertError);
		}
	}

})

</script>


@endsection