@extends('Shared/AdminLayout')



@section('title', 'Product Manager')



@section('head')

<style type="text/css">
	
#product-detail-overlay, #product-setting-overlay
{
	height: 100vh;
	width: 100vh;
	position: fixed;
	background: white;
	top:0;
	z-index: 99999999;
	display: none;	
	overflow-y: auto;
}

</style>

@endsection



@section('body')

<div class="container">
	<div id="product-detail-overlay">

		<div id="product-detail">
			
			<form id="myForm" @submit.prevent="handleSubmit">
			@csrf
			<div class="row">
				
				<div class="offset-2 col-8">
					<input type="hidden" name="id" value="">

					<div class="form-group">
						<img src="#" id="img" style="height:200px;width:200px;">	
						<input type="file" name="img" @change="previewImg">
					</div>

					<div class="form-group">
						<label for="name">Name</label>	
						<input type="text" name="name" class="form-control">
					</div>


					<div class="form-group">
						<label for="type">Type</label>	
						<select name="type" class="form-control">
							<option value="">Select Type</option>
							<option v-for="type in types" :value="type.type">@{{type.type}}</option>
						</select>
					</div>

					<div class="form-group">
						<label for="brand">Brand</label>
						<select name="brand" class="form-control">
							<option value="">Select Brand</option>
							<option v-for="brand in brands" :value="brand.brand">@{{brand.brand}}</option>
						</select>	
					</div>

					<div class="form-group">
						<label for="price">Price</label>	
						<input type="text" name="price" class="form-control">
					</div>

					<div class="form-group">
						<label for="qty">Qty in Stock</label>	
						<input type="text" name="qty" class="form-control">
					</div>

					<div class="form-group">
						<label for="imgDetail">Product Detail Image</label>	
						<br>
						<input type="file" name="imgDetail" @change="previewImgDetail">
						<br>
						<img src="#" id="imgDetail" style="height:400px;width:400px;">
					</div>

					<button type="submit">Submit</button>
					<button type="button" onclick="hideOverlay('product-detail-overlay')">Close</button>
				</div>

			</div>

			</form>
		</div>
		
	</div>

	<div id="product-setting-overlay">
		<div id="product-setting">
			<button type="button" onclick="hideOverlay('product-setting-overlay')">Close</button>
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


	<div class="row" id="product-manager">
		
		<div class="col-12 col-md-4">
			
			<input type="text" v-model="name" placeholder="search"><button @click="search()">Search</button>
			<br><br>
			<button onclick="showOverlay('product-detail-overlay')">Add item</button>
			<button onclick="showOverlay('product-setting-overlay')"><i class="fas fa-cog"></i></button>
			<br><br>
			<div class="nav nav-pills flex-column" id="v-pills-tab" role="tablist">
				
				<a class="nav-link active" id="pills-all-tab" data-toggle="pill"  aria-controls="pills-all" aria-selected="true" href="#" @click="typeSearch('')">All</a>

				<a v-for="type in types" class="nav-link" :id="'pills-all-' + type.type" data-toggle="pill" role="tab" :aria-controls="'pills-'+ type.type" aria-selected="false" href="#" @click="typeSearch(type.type)">@{{type.type}}</a>


			</div>
		</div>
		<div class="col-12 col-md-8">
			
			<div class="product-manager-list">
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
	el: "#product-manager",
	data :
	{
		productList:{!! json_encode($products) !!},
		types: {!! json_encode($types) !!},
		brands: {!! json_encode($brands) !!},
		name:'',
		type:'',
		img: '#'
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
			this.name='';
			this.type = type;
			var url = "/Product/search?type=" + this.type + "&brand=&name=";

			jsonAjax(url, "GET", "", function(response) {productManager.productList = response;}, function() {alert("Server Error")});
		},

		showOverlay()
		{
			document.getElementById("product-detail-overlay").style.display = "block";
		},

		hideOverlay()
		{
			document.getElementById("product-detail-overlay").style.display = "none";	
		},

	}

})

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
			img: "", 
			imgDetail: "",
			qty: ""
		},
		types: productManager.types,
		brands: productManager.brands

	},
	methods:
	{
		handleSubmit(event)
		{

			var form = new FormData(event.target);
			// form.append('id', event.target.elements.namedItem('id').value);

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

	},
	methods:
	{
		addType()
		{
			var obj = {type: this.newType};
			jsonAjax("/Product/AddType", "POST", JSON.stringify(obj), this.manageType, alertError);
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
				productDetail.types = response.Data;
				this.types = response.Data;
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
	}

})


</script>
@endsection