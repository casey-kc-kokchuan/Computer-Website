@extends('Shared/AdminLayout')



@section('title', 'Product Manager')



@section('head')

<style type="text/css">



/*Override default styling*/
#main
{
	padding-top:0;
	padding-bottom:0;
	background: white;
}

</style>

@endsection



@section('body')




<div id="product-manager" class="max-height">
	<div class="row max-height">
		<div class="col-12 col-lg-3 product-left-pane">

			<div class="row" style="width:100%;margin:0">
				<div class="product-control-box order-2 order-lg-1 col-12 ">
					<button  @click="addItem" class="btn-green add-btn"><i class="fas fa-plus"></i></button>
					<button onclick="toggleOverlay('#product-setting-overlay')" class="config-btn mt-lg-3 mt-0"><i class="fas fa-cog pr-lg-1 pr-0"></i><span class="config-txt">Configuration</span></button>
				</div>

				<div class="product-search-box order-1 order-lg-2 col-12 no-gutters">
					{{-- <h3>Search Box</h3> --}}
					<div class="form-group">
						<label for="">Name</label>
						<input type="text" v-model="name"  class="form-control" placeholder="Search">
					</div>
					<div class="form-group">

						<label for="">Type</label>
						<select v-model="type" class="form-control">
								<option value="">All</option>
								<option v-for="type in types" :value="type.type">@{{type.type}}</option>
						</select>
					</div>
					<div class="form-group">
						<label for="">Brand</label>
						<select v-model="brand" class="form-control">
							<option value="">All</option>
							<option v-for="brand in brands" :value="brand.brand">@{{brand.brand}}</option>
						</select>
					</div>


					<button @click="search()" class="btn-blue btn-size-form">Search</button>
					<button @click="clear()" class=" btn-size-form btn-red mt-lg-2 mt-0">Clear</button>
				</div>
			</div>

		</div>
		<div class="col-12 col-lg-9 product-right-pane">

			<div class="product-manager-list">
				<div v-for="(product, index) in productList" class="product" :class="{active: product.qty == 0}" id="product">

					<p><strong>@{{product.name}}</strong></p>
					<img :src="product.img + '?' + Math.random()" style="width:150px;height:100px">
					<p>RM&nbsp;@{{product.price}}</p>
					<p style="font-size:0.8em">@{{product.qty}} <i>in stock</i></p>


					<button @click="edit(index)" class="btn-blue btn-size-form">Edit</button>
					<button @click="remove(index)" class="btn-red btn-size-form"><i class="fas fa-times"></i></button>

				</div>
			</div>
		</div>

    </div>
</div>



<div id="product-detail-overlay">
	<div id="product-detail">


		<div class="row">

			<div class="col-12 col-lg-1">
				<button type="button" @click="hide" class="overlay-close-btn"><i class="fas fa-angle-right"></i></button>
			</div>

			<div class="col-12 col-lg-6">
				<form id="myForm" @submit.prevent="handleSubmit">
				@csrf

					<input type="hidden" name="id" v-model="productDetail.id">

					<div class="form-group">
						<center>

							<img :src="productDetail.img + '?' + Math.random()" id="img">
							<div class="file has-name pt-2">
							  <label class="file-label  mx-lg-auto">
							    <input type="file" name="img" @change="previewImg" ref="img" class="file-input">
							    <span class="file-cta">
							      <span class="file-icon">
							        <i class="fas fa-upload"></i>
							      </span>
							      <span class="file-label">
							        Choose a file…
							      </span>
							    </span>
							    <span class="file-name">
							      @{{ imgStatus }}
							    </span>
							  </label>
							</div>

							<p class="text-danger" v-if="error.img">@{{ error.img[0]}}</p>
						</center>


					</div>

					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" v-model="productDetail.name" name="name" class="form-control">
						<p class="text-danger" v-if="error.name">@{{ error.name[0]}}</p>
					</div>


					<div class="form-group">
						<label for="type">Type</label>
						<select name="type" class="form-control" v-model="productDetail.type">
							<option value="">Select Type</option>
							<option v-for="type in types" :value="type.type">@{{type.type}}</option>
							<option v-if="tempoType" :value="tempoType">@{{ tempoType }}</option>
						</select>
							<p class="text-danger" v-if="error.type">@{{ error.type[0]}}</p>
					</div>

					<div class="form-group">
						<label for="brand">Brand</label>
						<select name="brand" class="form-control" v-model="productDetail.brand">
							<option value="">Select Brand</option>
							<option v-for="brand in brands" :value="brand.brand">@{{brand.brand}}</option>
							<option v-if="tempoBrand" :value="tempoBrand">@{{ tempoBrand }}</option>
						</select>
							<p class="text-danger" v-if="error.brand">@{{ error.brand[0]}}</p>
					</div>

					<div class="form-group">
						<label for="price">Price</label>
						<input type="text" name="price" class="form-control" v-model="productDetail.price">
						<p class="text-danger" v-if="error.price">@{{ error.price[0]}}</p>
					</div>

					<div class="form-group">
						<label for="qty">Qty in Stock</label>
						<input type="text" name="qty" class="form-control" v-model="productDetail.qty">
						<p class="text-danger" v-if="error.qty">@{{ error.qty[0]}}</p>
					</div>

					<div class="form-group">
						<label for="imgDetail">Product Detail Image</label>

						<br>
						<div class="file has-name">
						  <label class="file-label">
						    <input type="file" name="imgDetail" ref="imgDetail" @change="previewImgDetail" class="file-input">
						    <span class="file-cta">
						      <span class="file-icon">
						        <i class="fas fa-upload"></i>
						      </span>
						      <span class="file-label">
						        Choose a file…
						      </span>
						    </span>
						    <span class="file-name">
						      @{{ imgDetailStatus }}
						    </span>
						  </label>
						</div>

						<p class="text-danger" v-if="error.imgDetail">@{{ error.imgDetail[0]}}</p>
						<br>
						<img :src="productDetail.imgDetail + '?' + Math.random()" id="imgDetail">
					</div>

					<button type="submit" class="btn-blue btn-size-form2" v-if="isEdit">Update</button>
					<button type="submit" class="btn-green btn-size-form2" v-else>Add</button>
				</form>
			</div>

		</div>

	</div>

</div>






<div id="product-setting-overlay">
	<div id="product-setting">
		<div class="row">

			<div class="col-12 col-lg-1">
				<button type="button" @click="hide" class="overlay-close-btn"><i class="fas fa-angle-right"></i></button>
			</div>

			<div class="col-12 col-lg-5 product-setting-table px-lg-2 px-4 mt-lg-5 mt-2">
				<h2>Types</h2>
				<input type="text" name="type" class="form-control d-inline" v-model="newType">
				<button type="button" class="btn-green btn-size-form" @click="addType()">Add</button>
				<button type="button" class="btn-red btn-size-form" @click="clearType">Clear</button>
				<br>
				<p class="text-danger" v-if="typeError.type">@{{ typeError.type[0]}}</p>
				<div id="typesTable" class="mt-2"></div>
			</div>
			<div class="col-12 col-lg-5  product-setting-table px-lg-2 px-4 mt-lg-5 mt-2">
				<h2>Brands</h2>
				<input type="text" name="type" class="form-control d-inline" v-model="newBrand">
				<button type="button" class="btn-green btn-size-form" @click="addBrand()">Add</button>
				<button type="button" class="btn-red btn-size-form" @click="clearBrand">Clear</button>
				<br>
				<p class="text-danger" v-if="brandError.brand">@{{ brandError.brand[0]}}</p>
				<div id="brandsTable" class="mt-2"></div>
			</div>
		</div>
	</div>
</div>





@endsection



@section('script')

<script type="text/javascript">
	var prod = {!! json_encode($products) !!};
	var tp = {!! json_encode($types) !!};
	var br = {!! json_encode($brands) !!} 
</script>
<script type="text/javascript" src={{ URL::asset('js/ProductManager.js')}}></script>
@endsection
