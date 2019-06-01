@extends('Shared/AdminLayout')



@section('title', 'Product Manager')



@section('head')

<style type="text/css">
	
#product-setting-overlay
{
	height: 100%;
	width: 100%;
	position: fixed;
	background: white;
	top:0;
	z-index: 10;
	display: none;	
	overflow-y: auto;
}

#product-detail-overlay
{
	height: 100%;
	width: 100%;
	position: fixed;
	top:0;
	right: -100vw; 	
	/*display:none;*/
	z-index: 1;
	transition: right 0.3s linear;

}

#product-detail-overlay.active/*, #product-detail-overlay.active #product-detail*/

{
	/*margin-left:0;*/
	/*height:0%;*/
	right: 0;
	/*display:block;*/

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



#main.active
{
	width: 100%;
}


.nav a.active
{
  background:  #5D8AA8 !important;
}

#main
{
	padding-top:0;
	padding-bottom:0;
}





</style>

@endsection



@section('body')


	
<div id="product-manager" class="max-height">
	<div class="row max-height">
		<div class="col-12 col-md-4 product-left-pane">
		
			<input type="text" v-model="name"  class="form-control d-inline" style="width:50%;"placeholder="Search"><button @click="search()" class="btn-blue btn-size-form">Search</button>
			<br><br>
			<button  @click="addItem" >Add item</button>
			<button onclick="showOverlay('#product-setting-overlay')"><i class="fas fa-cog"></i></button>
			<br><br>
			<div class="nav nav-pills flex-column" id="v-pills-tab" role="tablist">
				
				<a class="nav-link" v-bind:class="[ activetab === -1 ? 'active' : '' ]" id="pills-all-tab" data-toggle="pill"  aria-controls="pills-all" aria-selected="true" href="#" @click="activetab=-1;typeSearch('')">All</a>
				<a v-for="(type, index) in types" class="nav-link" v-bind:class="[ activetab === index ? 'active' : '' ]" :id="'pills-all-' + type.type" data-toggle="pill" role="tab" :aria-controls="'pills-'+ type.type" aria-selected="false" href="#" @click="activetab=index;typeSearch(type.type)">@{{type.type}}</a>


			</div>
		</div>
		<div class="col-12 col-md-8" style="background: #E0E0E0;">
			
			<div class="product-manager-list product-right-pane">
				<div v-for="(product, index) in productList" class="product" id="product">
					
					<p>@{{product.name}}</p>
					<img :src="product.img" style="width:150px;height:100px">
					<p>@{{product.price}}</p>


					<button @click="edit(index)">Edit</button>
					
				</div>
			</div>
		</div>
	</div>
</div>




<div id="product-detail-overlay" on-click="toggleOverlay('#product-detail-overlay')">
	<div id="product-detail">
		
		<form id="myForm" @submit.prevent="handleSubmit">
		@csrf
		<div class="row">
			
			<div class="offset-2 col-8">
				<input type="hidden" name="id" v-model="productDetail.id">

				<div class="form-group">
					<img :src=productDetail.img id="img" style="height:200px;width:200px;">	
					<input type="file" name="img" @change="previewImg" ref="img">
				</div>

				<div class="form-group">
					<label for="name">Name</label>	
					<input type="text" v-model="productDetail.name" name="name" class="form-control">
				</div>


				<div class="form-group">
					<label for="type">Type</label>	
					<select name="type" class="form-control" v-model="productDetail.type">
						<option value="">Select Type</option>
						<option v-for="type in types" :value="type.type">@{{type.type}}</option>
					</select>
				</div>

				<div class="form-group">
					<label for="brand">Brand</label>
					<select name="brand" class="form-control" v-model="productDetail.brand">
						<option value="">Select Brand</option>
						<option v-for="brand in brands" :value="brand.brand">@{{brand.brand}}</option>
					</select>	
				</div>

				<div class="form-group">
					<label for="price">Price</label>	
					<input type="text" name="price" class="form-control" v-model="productDetail.price">
				</div>

				<div class="form-group">
					<label for="qty">Qty in Stock</label>	
					<input type="text" name="qty" class="form-control" v-model="productDetail.qty">
				</div>

				<div class="form-group">
					<label for="imgDetail">Product Detail Image</label>	
					<br>
					<input type="file" name="imgDetail" @change="previewImgDetail">
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
		<button type="button" onclick="hideOverlay('product-setting-overlay', '')">Close</button>
		<br>
		<h2>Types</h2>

		<input type="text" name="type" v-model="newType">
		<button type="button" @click="addType()">Add</button>
		<button type="button" @click="newType=''">Clear</button>

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
		img: "#",
		activetab: -1,
	},
	methods:
	{
		search()
		{

			var url = "/Product/search?type=" + this.type + "&brand=&name=" + this.name;
			jsonAjax(url, "GET", "", function(response) {productManager.productList = response;}, function() {alert("Server Error")});
		},

		typeSearch(type)
		{
			this.name="";
			this.type = type;
			var url = "/Product/search?type=" + this.type + "&brand=&name=";

			jsonAjax(url, "GET", "", function(response) {productManager.productList = response;}, function() {alert("Server Error")});
		},

		edit(index)
		{
			showOverlay("product-detail-overlay",productDetailOverlay);
			productDetail.productDetail = this.productList[index];
			productDetail.isEdit = true;
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
			toggleOverlay('#product-detail-overlay',);
		}

	},

	watch: 
	{
		types: function()
		{
			productDetail.types = this.types;
			productSetting.types = this.types;
			this.activetab = -1;
			this.type = "";
		},

		brands: function()
		{
			productDetail.brands = this.brands;
			productSetting.brands = this.brands;
		}
	}

})

var productDetail = new Vue(
{
	el: "#product-detail-overlay",
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
		types: productManager.types,
		brands: productManager.brands,
		isEdit: true
	},
	methods:
	{
		handleSubmit(event)
		{
			alert('send')
			var form = new FormData(event.target);
			formAjax("/Admin", "POST", form , this.manageProductList, alertError);
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
		},

		manageProductList(response)
		{
			if(response.Status == "Success")
			{
				productManager.typeSearch(productManager.type);
				alert("success")
				return 0;
			}

			if(response.Status == "Validation Error")
			{
				alert(response.Message);
				return 0;
			}

			if(response.Status == "Database Error")
			{
				alert("DB error");
				return 0;	
			}
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
	el: "#product-setting-overlay",
	data:
	{
		types: productManager.types,
		brands: productManager.brands,
		newType: '',
		newBrand: '',

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
				// productDetail.types = response.Data;
				// this.types = response.Data;
				alert("success")
				return 0;
			}

			if(response.Status == "Validation Error")
			{
				alert(response.Message);
				return 0;
			}

			if(response.Status == "Database Error")
			{
				alert("DB error");
				return 0;	
			}
		},

		manageBrand(response)
		{
			if(response.Status == "Success")
			{
				productManager.brands = response.Data;
				productDetail.brands = response.Data;
				this.brands = response.Data;
				alert("success")
				return 0;
			}

			if(response.Status == "Validation Error")
			{
				alert(response.Message);
				return 0;
			}

			if(response.Status == "Database Error")
			{
				alert("DB error");
				return 0;
			}
		}
	},


})


</script>
@endsection