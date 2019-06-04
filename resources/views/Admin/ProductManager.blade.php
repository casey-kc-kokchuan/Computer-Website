@extends('Shared/AdminLayout')



@section('title', 'Product Manager')



@section('head')

<style type="text/css">
	
#product-setting-overlay
{
	height: 100%;
	width: 100%;
	position: fixed;
	top:0;
	right: -100vw; 
	z-index: 1;
	transition: right 0.3s linear;
}

#product-setting
{
	width:calc(100% - 250px - 5%);
	height: 100%;	

	position: absolute;

	background: white;

	right:0;
	top:0;

	padding:10px;
	overflow-y: auto;
	overflow-x: hidden;   
}

#product-detail-overlay
{
	height: 100%;
	width: 100%;
	position: fixed;
	top:0;
	right: -100vw; 	
	z-index: 1;
	transition: right 0.3s linear;

}

#product-detail-overlay.active, #product-setting-overlay.active/*, #product-detail-overlay.active #product-detail*/
{
	right: 0;

}

#product-detail
{
	border-top:5px solid black;
	border-left:5px solid black;
	width:calc(100% - 250px - 5%);

	height:95%;
	position: absolute;
	background: white;
	right:0;
	top:2%;
	overflow-y: auto;
	overflow-x: hidden;   
}




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
								<option value="">Select Type</option>
								<option v-for="type in types" :value="type.type">@{{type.type}}</option>
						</select>
					</div>
					<div class="form-group">
						<label for="">Brand</label>
						<select v-model="brand" class="form-control">
							<option value="">Select Brand</option>
							<option v-for="brand in brands" :value="brand.brand">@{{brand.brand}}</option>
						</select>	
					</div>


					<button @click="search()" class="btn-blue btn-size-form">Search</button>
					<button @click="clear()" class=" btn-size-form btn-red mt-lg-2 mt-0">Clear</button>
				</div>
			</div>
			


				
		
{{-- 			<div class="nav nav-pills flex-column" id="v-pills-tab" role="tablist">
				
				<a class="nav-link" v-bind:class="[ activetab === -1 ? 'active' : '' ]" id="pills-all-tab" data-toggle="pill"  aria-controls="pills-all" aria-selected="true" href="#" @click="activetab=-1;typeSearch('')">All</a>
				<a v-for="(type, index) in types" class="nav-link" v-bind:class="[ activetab === index ? 'active' : '' ]" :id="'pills-all-' + type.type" data-toggle="pill" role="tab" :aria-controls="'pills-'+ type.type" aria-selected="false" href="#" @click="activetab=index;typeSearch(type.type)">@{{type.type}}</a>
			</div> --}}
		</div>
		<div class="col-12 col-lg-9 product-right-pane" style="">
			
			<div class="product-manager-list">
				<div v-for="(product, index) in productList" class="product" id="product">
					
					<p>@{{product.name}}</p>
					<img :src="product.img" style="width:150px;height:100px">
					<p>@{{product.price}}</p>


					<button @click="edit(index)" class="btn-blue btn-size-form">Edit</button>
					<button @click="remove(index)" class="btn-red btn-size-form"><i class="fas fa-times"></i></button>
					
				</div>
			</div>
		</div>

    </div>
</div>



<div id="product-detail-overlay">
	<div id="product-detail">
		
		<form id="myForm" @submit.prevent="handleSubmit">
		@csrf
		<div class="row" class="product-detail-form">
			
			<div class="col-8">
				<input type="hidden" name="id" v-model="productDetail.id">

				<div class="form-group">
					<img :src=productDetail.img id="img" style="height:200px;width:200px;">	
					<input type="file" name="img" @change="previewImg" ref="img">
					<p class="text-danger" v-if="error.img">@{{ error.img[0]}}</p>
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
					</select>
						<p class="text-danger" v-if="error.type">@{{ error.type[0]}}</p>					
				</div>

				<div class="form-group">
					<label for="brand">Brand</label>
					<select name="brand" class="form-control" v-model="productDetail.brand">
						<option value="">Select Brand</option>
						<option v-for="brand in brands" :value="brand.brand">@{{brand.brand}}</option>
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
					<input type="file" name="imgDetail" @change="previewImgDetail">
					<p class="text-danger" v-if="error.imgDetail">@{{ error.imgDetail[0]}}</p>
					<br>
					<img :src="productDetail.imgDetail" id="imgDetail" style="height:400px;width:400px;">
				</div>

				<button type="submit" v-if="isEdit">Save</button>
				<button type="submit" v-else>Add</button>
				<button type="button" @click="hide">Close</button>
			</div>

		</div>

		</form>
	</div>
	
</div>






<div id="product-setting-overlay">
	<div id="product-setting">
		<button type="button" onclick="toggleOverlay('#product-setting-overlay')">Close</button>
		<br>
		<h2>Types</h2>

		<input type="text" name="type" v-model="newType">
		<button type="button" @click="addType()">Add</button>
		<button type="button" @click="newType=''">Clear</button>
		<br>
		<p class="text-danger" v-if="typeError.type">@{{ typeError.type[0]}}</p>					


		<h4>Exisiting Types</h4>
		<table style="border:1px solid black">
			<tr v-for="type in types">
				<td>@{{type.type}}</td>
				<td><button type="button" @click="removeType(type.type)">Remove</button></td>
			</tr>
		</table>

		<br><br>
		<h2>Brands</h2>

		<input type="text" name="type" v-model="newBrand">
		<button type="button" @click="addBrand()">Add</button>
		<button type="button" @click="newBrand=''">Clear</button>
		<br>
		<p class="text-danger" v-if="brandError.brand">@{{ brandError.brand[0]}}</p>					


		<h4>Exisiting Brands</h4>
		<table style="border:1px solid black">
			<tr v-for="brand in brands">
				<td>@{{brand.brand}}</td>
				<td><button type="button" @click="removeType(brand.brand)">Remove</button></td>
			</tr>
		</table>


	</div>	
</div>





@endsection



@section('script')

<script type="text/javascript">
	
var productManager = new Vue(
{
	el: "#product-manager",
	data :
	{
		productList:{!! json_encode($products) !!},
		types: {!! json_encode($types) !!},
		brands: {!! json_encode($brands) !!},
		name:"",
		type:"",
		brand: "",
		img: "#",
	},
	methods:
	{
		search()
		{

			var url = "/Product/search?type=" + this.type + "&brand="+ this.brand +"&name=" + this.name;
			jsonAjax(url, "GET", "", function(response) {productManager.productList = response;}, alertError);
		},

		typeSearch(type)
		{
			this.name="";
			this.type = type;
			var url = "/Product/search?type=" + this.type + "&brand=&name=";

			jsonAjax(url, "GET", "", function(response) {productManager.productList = response;}, alertError);
		},

		edit(index)
		{
			toggleOverlay("#product-detail-overlay");
			productDetail.productDetail = this.productList[index];
			productDetail.isEdit = true;
		},

		remove(index)
		{
			Swal.fire(
			{
				type: 'warning',
				title: 'Are you sure on removing this product?',
				showCancelButton:true,
				cancelButtonColor:'#d9534f',
				cancelButtonText: "No",
				confirmButtonColor:'#5cb85c',
				confirmButtonText: 'Yes'
			}).then((result) =>
				{
					if(result.value)
					{

						jsonAjax("/Product/RemoveProduct", "POST", JSON.stringify({id: this.productList[index].id}), function(response)
							{
								if(response.Status == "Success")
								{

									SwalSuccess('Product is succesfully removed.','');
									this.productList = response.Data;
									return 0;
								}

								// if(response.Status == "Validation Error")
								// {
								// 	SwalError('Invalid detail. Please check error messages.','');
								// 	this.error = response.Message;
								// 	return 0;
								// }

								if(response.Status == "Database Error")
								{
									SwalError('Database Error. Please contact administrator.','');
								}

							}, alertError );

					}
				});
		},

		addItem()
		{
			productDetail.productDetail =
			{
				id: "", 
				name: "", 
				type: "",
				brand: "",
				price: "",
				img: "#", 
				imgDetail: "#",
				qty: ""
			};
			productDetail.isEdit = false;
			toggleOverlay('#product-detail-overlay');
		},

		clear()
		{
			this.name ="";
			this.type ="";
			this.brand ="";
			this.search();
		}

	},

	watch: 
	{
		types: function()
		{
			productDetail.types = this.types;
			productSetting.types = this.types;
			this.type = "";
		},

		brands: function()
		{
			productDetail.brands = this.brands;
			productSetting.brands = this.brands;
			this.brand = ""
		}
	}

});

var productDetail = new Vue(
{
	el: "#product-detail",
	data:
	{
		productDetail: 
		{
			id: "", 
			name: "", 
			type: "",
			brand: "",
			price: "",
			img: "#", 
			imgDetail: "#",
			qty: ""
		},
		error:
		{
			name: [], 
			type: [],
			brand: [],
			price: [],
			img: [], 
			imgDetail: [],
			qty: []
		},
		types: productManager.types,
		brands: productManager.brands,
		isEdit: true,
	},
	methods:
	{
		handleSubmit(event)
		{
		
			var form = new FormData(event.target);
			formAjax("/Product/AddProduct", "POST", form , this.manageProductList, alertError);
		},

		previewImg(event)
		{
			var reader = new FileReader();

			reader.onload = function(e) 
			{
			  $('#img').attr('src', e.target.result);
			}

			reader.readAsDataURL(event.target.files[0]);
		},

		previewImgDetail(event)
		{
			var reader = new FileReader();

			reader.onload = function(e) 
			{
			  $('#imgDetail').attr('src', e.target.result);
			}

			reader.readAsDataURL(event.target.files[0]);

		},

		hide()
		{
			this.$refs.img.value = '';	
			$("#img").attr('src', '#');
			$("#imgDetail").attr('src', '#');
			toggleOverlay('#product-detail-overlay');
			this.emptyError();
		},

		manageProductList(response)
		{
			if(response.Status == "Success")
			{
				// productManager.typeSearch(productManager.type);

				// if(isEdit)
				// {
				// 	SwalSuccess('Product is successfully editted.','')
				// }
				// else
				// {
				// 	SwalSuccess('New product is successfully added.','')
				// }
					SwalSuccess('New product is successfully added.','')

				this.emptyError();
				this.hide();
				return 0;
			}

			if(response.Status == "Validation Error")
			{
				this.error = response.Message;
				SwalError('Invalid detail. Please check error messages.','')
				return 0;
			}

			if(response.Status == "Database Error")
			{
				SwalError('Database Error. Please contact administrator.','')
			}
		},

		emptyError()
		{
			this.error = 		
			{
				name: [], 
				type: [],
				brand: [],
				price: [],
				img: [], 
				imgDetail: [],
				qty: []
			};
		},

	},

	watch:
	{
		productDetail: function ()
		{
			this.productDetail.img = this.productDetail.img;
		},
	}
})


var productSetting = new Vue(
{
	el: "#product-setting",
	data:
	{
		types: productManager.types,
		brands: productManager.brands,
		newType: '',
		newBrand: '',
		typeError: [],
		brandError: [],
	},
	methods:
	{
		addType()
		{
			var obj = {type: this.newType};
			jsonAjax("/Admin", "POST", JSON.stringify(obj), this.manageType, alertError);
		},

		removeType(val)
		{
			var obj = {type: this.newType};
			jsonAjax("/Product/RemoveType", "POST", JSON.stringify(obj), this.manageType, alertError);
		},

		addBrand()
		{
			var obj = {brand: this.newBrand};
			jsonAjax("/Product/AddBrand", "POST", JSON.stringify(obj), this.manageBrand, alertError);
		},

		removeBrand()
		{
			var obj = {brand: this.newBrand};
			jsonAjax("/Product/RemoveBrand", "POST", JSON.stringify(obj), this.manageBrand, alertError);
		},

		manageType(response)
		{
			if(response.Status == "Success")
			{

				productManager.types = response.Data;
				this.typeError = [];
				SwalSuccess('New type is successfully added.','');
				return 0;
			}

			if(response.Status == "Validation Error")
			{
				SwalError('Invalid detail. Please check error messages.','');
				this.typeError = response.Message;
				return 0;
			}

			if(response.Status == "Database Error")
			{
				SwalError('Database Error. Please contact administrator.','');
			}
		},

		manageBrand(response)
		{
			if(response.Status == "Success")
			{
				productManager.brands = response.Data;
				this.brandError = [];
				SwalSuccess('New brand is successfully added.')
				return 0;
			}

			if(response.Status == "Validation Error")
			{
				SwalError('Invalid detail. Please check error messages.','');
				this.brandError = response.Message;
				return 0;
			}

			if(response.Status == "Database Error")
			{
				SwalError('Database Error. Please contact administrator.','');
			}
		},
		

	},
})


</script>
@endsection