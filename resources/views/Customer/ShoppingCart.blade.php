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
				<div v-for="(product, index) in productList" class="product" :class="{active : product.qty == 0}" id="product">
					<div class="row no-gutters max-height">
						<div class="col-lg-4">
							<img :src="product.img">
						</div>
						<div class="col-lg-8">
							<p class="p-name">@{{product.name}}</p>
							<p class="p-price">RM&nbsp;@{{ formatPrice(product.price) 	}}</p>
							<p class="p-sold-out"  v-if="product.qty == 0">OUT OF STOCK</p>
							<p class="p-qty" v-else>@{{product.qty}}&nbsp;<i>in stock</i>	</p>


							<div class="btn-position" v-if="product.qty != 0">
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
					<p class="c-name">@{{cart.name}}</p>
					<img :src="cart.img" style="width:150px;height:100px">
					<p>RM&nbsp;@{{ formatPrice(cart.price)}}</p>
					<p>Qty: @{{cart.qty}}</p>
					<button @click="removeFromCart(index)" class="btn-red"><i class="fas fa-minus"></i></button>

				</div>
			</div>

			<div class="order-box">
				<p class="float-lg-left total-price" style="">Total: RM @{{ formatPrice(total_price) }}</p>
				<button class="float-lg-right btn-yellow btn-size-form" onclick="toggleOverlay('#place-order-overlay')">Place Order</button>
			</div>


		</div>


		
		<div id="about-product-overlay">
			<div id="about-product">
				<div class="row no-gutters">
					<div class="col-12">
						<button class="overlay-close-btn2" type="button" onclick="toggleOverlay('#about-product-overlay')"><i class="fas fa-angle-down"></i></button>
					</div>
					<div class="col-12 col-lg-8 offset-lg-2 text-center">
						<div class="row no-gutters about-product-detail">
							<div class="col-6 text-center img-box">
								<img  class="img" :src="aboutProduct.img" >
							</div>
							<div class="col-6 text-left detail-box">
								<p class="a-name">@{{ aboutProduct.name }}</p >
								<p class="a-price">RM&nbsp;@{{formatPrice(aboutProduct.price) }}</p>
								<p class="a-qty">@{{ aboutProduct.qty}}&nbsp;<i>in stock</i></p>
							</div>
							<div class="col-12 img-detail-box">
								<p>Product Detail</p>
								<img class="imgDetail" :src="aboutProduct.imgDetail">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<div id="place-order-overlay">
	<div id="place-order">
		<div class="row no-gutters">
			<div class="col-12">
				<button class="overlay-close-btn2" type="button" onclick="toggleOverlay('#place-order-overlay')"><i class="fas fa-angle-down"></i></button>
			</div>
			<div class="col-12 col-lg-6 offset-lg-3">
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

					<button class="btn-yellow btn-size-form2" style="width:100%">Submit</button>

				</form>
			</div>
		</div>	

	</div>
</div>



@endsection



@section('script')

<script type="text/javascript">
	var data = {!! json_encode($products) !!};

</script>


<script type="text/javascript" src={{ URL::asset('js/ShoppingCart.js')}}></script>

@endsection