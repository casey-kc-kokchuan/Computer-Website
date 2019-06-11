@extends('Shared/AdminLayout')



@section('title', 'Account')



@section('head')

<style type="text/css">
	


</style>

@endsection



@section('body')




<div class="row account-box">
	<div class="col-12 col-lg-11 account-btn-box">
		<button class="btn-green btn-size-form addBtn" onclick="accountDetail.isEdit=false;toggleOverlay('#account-detail-overlay')"><i class="fas fa-user-plus mr-2"></i>Add Account</button>
		<div class="account-table-box">
			<div id="account-table"></div>
		</div>
	</div>
</div>


<div id="account-detail-overlay">
	<div id="account-detail">
		<div class="row">
			<div class="col-12 col-lg-1">
				<button type="button" @click="hide" class="overlay-close-btn"><i class="fas fa-angle-right"></i></button>
			</div>

			<div class="col-12 col-lg-8">
				<form  @submit.prevent="handleSubmit">
			@csrf
					
					<input type="hidden" name="id" v-model="accountDetail.id">

					<div class="form-group">
						<label for="">Username</label>
						<input type="text" name="username" class="form-control" v-model="accountDetail.username" :disabled="isEdit">
						<p class="text-danger" v-if="error.username">@{{ error.username[0] }}</p>
					</div>

					<div class="form-group" v-if="!isEdit">
						<label for="">Password</label>
						<input type="password" name="password" class="form-control" v-model="accountDetail.password">
						<p class="text-danger" v-if="error.password">@{{ error.password[0] }}</p>
					</div>

					<div class="form-group" v-if="!isEdit">
						<label for="">Confirm Password</label>
						<input type="password" v-model="accountDetail.confirmPassword" class="form-control">
						<p class="text-danger" v-if="error.password">@{{ error.password[0] }}</p>

					</div>

					<div class="form-group">
						<label for="">Full Name</label>
						<input type="text" name="full_name" class="form-control" v-model="accountDetail.full_name">
						<p class="text-danger" v-if="error.full_name">@{{ error.full_name[0] }}</p>
					</div>

					<div class="form-group">
						<label for="">Role</label>
						<select name="role" v-model="accountDetail.role" class="form-control">
							<option value="">Select Role</option>
							<option value="Admin">Admin</option>
							<option value="Store Manager">Store Manager</option>
							<option value="Product Manager">Product Manager</option>
							<option value="Sales Assistant">Sales Assistant</option>
						</select>
						<p class="text-danger" v-if="error.role">@{{ error.role[0] }}</p>
					</div>

					<div class="form-group">
						<label for="">Gender</label>
						<select name="gender" v-model="accountDetail.gender" class="form-control">
							<option value="">Select Gender</option>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
						</select>
						<p class="text-danger" v-if="error.gender">@{{ error.gender[0] }}</p>
					</div>

					<div class="form-group">
						<label for="">Contact No</label>
						<input type="text" name="contact" class="form-control" v-model="accountDetail.contact">
						<p class="text-danger" v-if="error.contact">@{{ error.contact[0] }}</p>
					</div>

					<div class="form-group">
						<label for="">Email Address</label>
						<input type="text" name="email" class="form-control" v-model="accountDetail.email">
						<p class="text-danger" v-if="error.email">@{{ error.email[0] }}</p>
					</div>


					<button type="submit" class="btn-blue btn-size-form" style="width:100%" v-if="isEdit">Update</button>
					<button type="submit" class="btn-green btn-size-form" style="width:100%" v-else>Add</button>
				</form>
			</div>
		</div>
	</div>

</div>


@endsection


@section('script')
<script>

var deleteIcon = function(cell, formatterParams, onRendered)
{
	// return '<i class="fas fa-times" style="color:red;"></i>';
	return '<button class="btn-red"><i class="fas fa-times"></i></button>'
}

var editIcon = function(cell, formatterParams, onRendered)
{
	return '<i class="far fa-edit"></i>';

}

var passwordIcon = function(cell, formatterParams, onRendered)
{
	return '<i class="fas fa-user-lock"></i>';
}

var table = new Tabulator("#account-table",{
	layout: "fitDataFill",
	data: {!! json_encode($Data) !!},
	headerFilterPlaceholder: "Search",
	columns:
	[
		{title:"ID", field:"id"},
		{title:"Username", field:"username", headerFilter:true},
		{title:"Full Name", field:"full_name", headerFilter:true},
		{title:"Role", field:"role", headerFilter:true},
		{title:"Gender", field:"gender", headerFilter:true},
		{title:"Contact No", field:"contact", headerFilter:true},
		{title:"Email", field:"email", headerFilter:true},
		{title:"Edit", formatter:editIcon, align:"center", tooltip:"Edit", 
			cellClick(e, cell)
			{
				var obj = {};
				Object.assign(obj, cell.getData())
				accountDetail.accountDetail = obj;
				accountDetail.isEdit = true;
				toggleOverlay('#account-detail-overlay');
			}
		},
		{title:"Remove", formatter:deleteIcon, align:"center", tooltip:"Remove",
			cellClick(e, cell)
			{
				Swal.fire(
				{
					type: 'warning',
					title: 'Are you sure on removing this account?',
					showCancelButton:true,
					cancelButtonColor:'#d9534f',
					cancelButtonText: "No",
					confirmButtonColor:'#5cb85c',
					confirmButtonText: 'Yes'
				}).then((result) =>
					{
						if(result.value)
						{

							jsonAjax("/Account/RemoveAccount", "POST", JSON.stringify({id: cell.getData().id}), function(response)
								{
									if(response.Status == "Success")
									{

										SwalSuccess('Account is succesfully removed.','');
										table.setData();
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
		},
		{title:"Change Password", formatter:passwordIcon, align:"center", tooltip:"Change Password",cellClick(e, cell)
			{
				(
				async function getFormValues () 
				{
					const {value: formValues} = await Swal.fire(
					{
					  title: 'Change Password',
					  html:
					    '<input type="password" id="password" class="swal2-input" placeholder="Password">' + 
					    '<input type="password" id="confirmPassword" class="swal2-input" placeholder="Confirm Password">' +
					    '<p id="err" class="text-danger"></p>' ,
					  focusConfirm: false,
					  showCancelButton:true,
					  cancelButtonColor:'#d9534f',
					  cancelButtonText: "No",
					  confirmButtonColor:'#5cb85c',
					  confirmButtonText: 'Save',
					  preConfirm: ()=>
					  {
					  	let password = document.getElementById('password').value;
					  	let confirmPassword = document.getElementById('confirmPassword').value;

					  	if( password && confirmPassword)
					  	{

					  		if(password.length < 8 || password.length > 255)
					  		{
					  			document.getElementById('err').innerHTML = "The password must be between 8 and 255 characters.";
					  		}
					  		else
					  		{
					  			if(password == confirmPassword)
					  			{
					  				
					  				return {
					  					id: cell.getData().id,
					  					password: password
					  				}
					  			}
					  			else
					  			{
					  				document.getElementById('err').innerHTML = "Password does not match.";
					  				document.getElementById('password').value  = "";
					  				document.getElementById('confirmPassword').value  = "";
					  			}
					  		}

					  	}	
					  	else
					  	{
					  		document.getElementById('err').innerHTML = "Both field is required.";
					  	}
					    return false;
					  }
					})

					if (formValues) 
					{

						jsonAjax("/Account/ChangePassword", "POST", JSON.stringify(formValues) ,function(response)
							{
								if(response.Status == "Success")
								{

									SwalSuccess('Password is successfully changed.','');
									return 0;
								}

								if(response.Status == "Validation Error")
								{
									SwalError('Validation Error' ,response.Message.password[0]);
									return 0;
								}

								if(response.Status == "Database Error")
								{
									SwalError('Database Error. Please contact administrator.','');
								}
							}
							,alertError);

					}
				})()
			}
		},
		
	],
	ajaxURL: "/Account/ShowAllData", 
})

var accountDetail = new Vue(
{
	el:"#account-detail",
	data:
	{
		accountDetail:
		{
			id:"",
			username:"",
			password: "",
			confirmPassword: "",
			full_name:"",
			gender: "",
			contact: "",
			email:"",
			role:""
		},
		error: {},
		isEdit: false
	},
	methods:
	{
		handleSubmit(event)
		{
			var formData = new FormData(event.target);

			if(this.isEdit)
			{
				formAjax("/Account/EditAccount", "POST", formData, this.editAccount, alertError);
			}
			else
			{

				if(this.checkPassword())
				{

					formAjax("/Account/AddAccount", "POST", formData, this.addAccount, alertError);
				}
				else
				{
					SwalError('Invalid detail. Please check error messages.', '');
					this.error = { password: ["Password does not match."]};
				}
			}
		},

		hide()
		{
			this.accountDetail = 
			{
				id:"",
				username:"",
				password: "",
				confirmPassword: "",
				full_name:"",
				gender: "",
				contact: "",
				email:"",
				role:""
			}
			this.error = {};
			toggleOverlay('#account-detail-overlay')
		},

		addAccount(response)
		{
			if(response.Status == "Success")
			{

				SwalSuccess('New account is successfully added.','');
				table.setData(response.Data);
				this.hide();
				return 0;
			}

			if(response.Status == "Validation Error")
			{
				SwalError('Invalid detail. Please check error messages.','');
				this.error = response.Message;
				return 0;
			}

			if(response.Status == "Database Error")
			{
				SwalError('Database Error. Please contact administrator.','');
			}
		},

		editAccount(response)
		{
			if(response.Status == "Success")
			{

				SwalSuccess('Account is successfully edited.','');
				table.setData(response.Data);
				this.hide();
				return 0;
			}

			if(response.Status == "Validation Error")
			{
				SwalError('Invalid detail. Please check error messages.','');
				this.error = response.Message;
				return 0;
			}

			if(response.Status == "Database Error")
			{
				SwalError('Database Error. Please contact administrator.','');
			}
		},

		checkPassword()
		{
			if(this.accountDetail.password == this.accountDetail.confirmPassword)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
})

</script>

@endsection