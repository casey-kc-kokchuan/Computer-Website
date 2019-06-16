@extends('Shared/CustomerLayout')



@section('title', 'Shopping Cart')



@section('head')

<style type="text/css">


/*override container fluid	*/
.container-fluid
{
	padding: 0px !important;
}

</style>
@endsection



@section('body')

<div class="container-fluid ">
	<div class="row no-gutters" id="shoppingCart">


		<div class="col-12 col-lg-2 max-height cart-search-box">

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

			
			<button @click="search" type="button" class="btn-yellow btn-size-form mt-lg-3">Search</button>
			<button @click="clear" type="button" class="btn-red btn-size-form mt-lg-3">Clear</button>
		</div>

		<div class="col-12 col-lg-5 product-list">
				<div v-for="(product, index) in productList" class="product" id="product">
					<div class="row no-gutters max-height">
						<div class="col-lg-4">
							<img :src="product.img">
						</div>
						<div class="col-lg-8">
							<p><strong>@{{product.name}}</strong></p>
							<p>RM&nbsp;@{{ formatPrice(product.price) 	}}</p>
							<p style="font-size:0.8em">@{{product.qty}} <i>in stock</i></p>


							<div class="btn-position">
								<button @click="addToCart(index)" class="btn-green btn-size-form"><i class="fas fa-cart-plus"></i><span class="atc">&nbsp;Add To Cart</span></button>
								<button class="btn-blue btn-size-form" @click="about(index)">About</button>
							</div>
						</div>
					</div>
					
				</div>
		</div>

		<div class="col-12 col-lg-5 max-height">
			<div class="cart-list">
				<div v-for="(cart, index) in cartList" class="cart" id="cart" >
					<p><strong>@{{cart.name}}</strong></p>
					<img :src="cart.img" style="width:150px;height:100px">
					<p>RM&nbsp;@{{ formatPrice(cart.price)}}</p>
					<p>Qty: @{{cart.qty}}</p>
					<button @click="removeFromCart(index)" class="btn-red"><i class="fas fa-minus"></i></button>

				</div>
			</div>

			<div class="order-box">
				<p class="float-lg-left" style="color:#F9D342;font-size:18px;font-weight:600">Total: RM @{{ formatPrice(total_price) }}</p>
				<button class="float-lg-right btn-yellow btn-size-form" onclick="toggleOverlay('#place-order-overlay')">Place Order</button>
			</div>


		</div>


		
		<div id="about-product-overlay">
			<div id="about-product">
				<button onclick="toggleOverlay('#about-product-overlay')">Close</button>
				<h3>@{{ aboutProduct.name }}</h3>
				<img :src="aboutProduct.img" style="width:150px;height:150px;">
				<p>RM&nbsp;@{{ formatPrice(aboutProduct.price) }}</p>
				<img :src="aboutProduct.imgDetail">
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
				<p class="text-danger" v-if="error.name">@{{ error.name[0] }}</p>
			</div>
			<div class="form-group">
				<label>Email</label>
				<input type="text" class="form-control" v-model="orderDetail.email">
				<p class="text-danger" v-if="error.email">@{{ error.email[0] }}</p>	
			</div>
			<div class="form-group">
				<label>Contact</label>
				<input type="text" class="form-control" v-model="orderDetail.contact">
				<p class="text-danger" v-if="error.contact">@{{ error.contact[0] }}</p>

			</div>
			<div class="form-group">
				<label>Address</label>
				<input type="text" class="form-control" v-model="orderDetail.address">
				<p class="text-danger" v-if="error.address">@{{ error.address[0] }}</p>
			</div>

			<button>Submit</button>
			<button onclick="toggleOverlay('#place-order-overlay')" type="button">Close</button>
		</form>
	</div>
</div>



@endsection



@section('script')

<script type="text/javascript">


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
		aboutProduct: { name: "", img: "/img/placeholder.png", price: 0.00, imgDetail: "/img/placeholder.png"}
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
				if(obj.qty <= 0)
				{
					alert("nope");
				}
				else
				{
					obj.qty = 1;
					this.cartList.push(obj);
					this.total_price += this.productList[index].price;
				}
			}
			else
			{
				if(obj.qty <= this.cartList[matchingIndex].qty)
				{
					alert("nope");
				}
				else
				{
					this.cartList[matchingIndex].qty += 1;
					this.total_price += this.productList[index].price;
				}
			}
			
			
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

		about(index)
		{
			this.aboutProduct = this.productList[index];
			toggleOverlay("#about-product-overlay");
		},

		formatPrice(value) 
		{
	       return val = (value).toFixed(2);	
	    },

	    clear()
	    {
	    	this.searchName = "";
	    	this.searchType = "";
	    	this.searchBrand = "";
	    	this.search();
	    },

	    recalculate()
	    {
	    	var total = 0;

	    	for(var i = 0; i < this.cartList.length; i++)
	    	{
	    		total += this.cartList[i].price * this.cartList[i].qty;
	    	}

	    	this.total_price = total;
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
		},
		error: {},
	},
	methods:
	{
		handleSubmit(event)
		{	
			if(shoppingCart.cartList.length <= 0)
			{
				SwalError("Cart is empty. Unable to place order.", "");
				return 0;
			}
			var obj = {};
			Object.assign(obj, this.orderDetail);
			obj.cart = shoppingCart.cartList;
			obj.total_price = shoppingCart.formatPrice(shoppingCart.total_price);
			obj.searchName = shoppingCart.searchName;
			obj.searchType = shoppingCart.searchType;
			obj.searchBrand = shoppingCart.searchBrand;

			jsonAjax("/Order/PlaceOrder", "POST", JSON.stringify(obj) ,function(response)
				{
					if(response.Status == "Success")
					{
						location.replace(response.Link);
						return 0;
					}

					if(response.Status == "Quantity Error")
					{
						toggleOverlay("#place-order-overlay");
						shoppingCart.productList = response.Data;
						var data = response.Message;
						var txt ="";
						
						for(var i = 0; i < data.length; i++)
						{
							var	matchingIndex = shoppingCart.cartList.findIndex(x => x.id == data[i].id);

							var counter = i +1;
							if(data[i].qty <= 0)
							{
								txt += "<p>" + counter+ ". " + shoppingCart.cartList[matchingIndex].name + " <i class='fas fa-arrow-right'></i> 0(Removed)</p>"; 
								shoppingCart.cartList.splice(matchingIndex, 1);
							}
							else
							{
								shoppingCart.cartList[matchingIndex].qty = data[i].qty;
								txt += "<p>" + counter + ". " + shoppingCart.cartList[matchingIndex].name + " <i class='fas fa-arrow-right'></i> " + data[i].qty + "</p>"; 
							}
						}

						Swal.fire(
						{
							title: "Apologies, we are running out of stock for item(s) ordered.",
							html: '<p>Cart is automatically refreshed, changes are as follow:<p>' + txt,
						});
						shoppingCart.recalculate();
						return 0;
					}	

					if(response.Status == "Validation Error")
					{
						SwalError("Validation Error", '');
						orderDetail.error = response.Message;
						return 0;
					}

					if(response.Status == "Database Error")
					{
						SwalError("Database Error", "");
						return 0;
					}

				}, alertError);
		}
	}

})

</script>


@endsection