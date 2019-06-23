
var productManager = new Vue(
{
	el: "#product-manager",
	data :
	{
		productList: prod,
		types: tp,
		brands: br,
		name:"",
		type:"",
		brand: "",
		img: "/img/placeholder.png",

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

			var matchingType = this.types.findIndex(x => x.type == this.productList[index].type);
			if(matchingType == -1)
			{
				productDetail.tempoType = this.productList[index].type;
			}

			var matchingBrand = this.brands.findIndex(x => x.brand == this.productList[index].brand );

			if(matchingBrand == -1)
			{
				productDetail.tempoBrand = this.productList[index].brand;
			}

			var obj = {};
			Object.assign(obj, this.productList[index]);
			productDetail.productDetail = obj;
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

						var obj = {id: this.productList[index].id, searchName: productManager.name, searchType: productManager.type, searchBrand: productManager.brand};
						jsonAjax("/Product/RemoveProduct", "POST", JSON.stringify(obj), function(response)
							{
								if(response.Status == "Success")
								{

									SwalSuccess('Product is succesfully removed.','');
									productManager.productList = response.Data;
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
			typesTable.setData(this.types);
			this.type = "";
		},

		brands: function()
		{
			productDetail.brands = this.brands;
			brandsTable.setData(this.brands);
			this.brand = ""
		}
	},


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
			img: "/img/placeholder.png",
			imgDetail: "/img/placeholder.png",
			qty: "",

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
		imgStatus: "No file is selected",
		imgDetailStatus: "No file is selected",
		tempoType: "",
		tempoBrand: "",
		isEdit: true,
	},
	methods:
	{
		handleSubmit(event)
		{
			var form = new FormData(event.target);
			form.append("searchName", productManager.name)
			form.append("searchType", productManager.type)
			form.append("searchBrand", productManager.brand)

			if(this.isEdit)
			{
				formAjax("/Product/EditProduct", "POST", form , this.editProductList, alertError);
			}
			else
			{
				formAjax("/Product/AddProduct", "POST", form , this.addProductList, alertError);
			}
		},

		previewImg(event)
		{
			var reader = new FileReader();

			reader.onload = function(e)
			{
			  $('#img').attr('src', e.target.result);
			}

			reader.readAsDataURL(event.target.files[0]);
			this.imgStatus = event.target.files[0].name;
		},

		previewImgDetail(event)
		{
			var reader = new FileReader();

			reader.onload = function(e)
			{
			  $('#imgDetail').attr('src', e.target.result);
			}

			reader.readAsDataURL(event.target.files[0]);
			this.imgDetailStatus = event.target.files[0].name;

		},

		hide()
		{
			this.$refs.img.value = '';
			this.$refs.imgDetail.value = '';
			this.tempoBrand = '';
			this.tempoType = '';
			this.imgDetailStatus = "No file is selected";
			this.imgStatus = "No file is selected";
			this.productDetail =
				{
					id: "",
					name: "",
					type: "",
					brand: "",
					price: "",
					img: "/img/placeholder.png",
					imgDetail: "/img/placeholder.png",
					qty: ""
				};
			$("#img").attr('src', '/img/placeholder.png');
			$("#imgDetail").attr('src', '/img/placeholder.png');
			toggleOverlay('#product-detail-overlay');
			this.emptyError();
		},

		addProductList(response)
		{
			if(response.Status == "Success")
			{
				SwalSuccess('New product is successfully added.','')
				productManager.productList = response.Data;
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

		editProductList(response)
		{
			if(response.Status == "Success")
			{
				SwalSuccess('Edit is successful.','')
				productManager.productList = response.Data;
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
	},


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
			jsonAjax("/Product/AddType", "POST", JSON.stringify(obj), this.manageType, alertError);
		},

		addBrand()
		{
			var obj = {brand: this.newBrand};
			jsonAjax("/Product/AddBrand", "POST", JSON.stringify(obj), this.manageBrand, alertError);
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

		hide()
		{
			this.newType ='';
			this.newBrand ='';
			this.typeError = [];
			this.brandError =[];
			toggleOverlay('#product-setting-overlay')
		},

		clearType()
		{
			this.typeError = [];
			this.newType = '';
		},

		clearBrand()
		{
			this.brandError =[];
			this.newBrand ='';
		}



	},
})


var deleteIcon = function(cell, formatterParams, onRendered)
{
	return '<i class="fas fa-times" style="color:red;"></i>';
}

var typesTable = new Tabulator('#typesTable',
{
	layout: "fitColumns",
	headerFilterPlaceholder: "Search",
	data: productManager.types,
	columns:
	[

		{title: "ID", field: "id", visible: false},
		{title: "Type", field: "type", headerFilter:true, widthGrow: 3},
		{title:"Remove", formatter:deleteIcon, widthGrow: 2, align:"center", tooltip:"Remove",
			cellClick(e, cell)
			{
				Swal.fire(
				{
					type: 'warning',
					title: 'Are you sure on removing this?',
					text: 'Type: ' + cell.getData().type,
					showCancelButton:true,
					cancelButtonColor:'#d9534f',
					cancelButtonText: "No",
					confirmButtonColor:'#5cb85c',
					confirmButtonText: 'Yes'
				}).then((result) =>
					{
						if(result.value)
						{

							jsonAjax("/Product/DeleteType", "POST", JSON.stringify({id: cell.getData().id}), function(response)
								{
									if(response.Status == "Success")
									{

										SwalSuccess('Type is successfully removed','');
										productManager.types = response.Data;
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

			}
		}

	]
});


var brandsTable = new Tabulator('#brandsTable',
{
	layout: "fitColumns",
	headerFilterPlaceholder: "Search",
	data: productManager.brands,
	columns:
	[
		{title: "ID", field: "id", visible: false},
		{title: "Brand", field: "brand", headerFilter:true, widthGrow: 3},
		{title:"Remove", formatter:deleteIcon, widthGrow: 2, align:"center", tooltip:"Remove",
			cellClick(e, cell)
			{
				Swal.fire(
				{
					type: 'warning',
					title: 'Are you sure on removing this?',
					text: 'Brand: ' + cell.getData().brand,
					showCancelButton:true,
					cancelButtonColor:'#d9534f',
					cancelButtonText: "No",
					confirmButtonColor:'#5cb85c',
					confirmButtonText: 'Yes'
				}).then((result) =>
					{
						if(result.value)
						{
							jsonAjax("/Product/DeleteBrand", "POST", JSON.stringify({id: cell.getData().id}), function(response)
								{
									if(response.Status == "Success")
									{

										SwalSuccess('Brand is successfully removed','');
										productManager.brands = response.Data;
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

			}
		}

	]
})
