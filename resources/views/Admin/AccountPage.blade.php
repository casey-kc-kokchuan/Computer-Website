@extends('Shared/AdminLayout')



@section('title', 'Account')



@section('head')

<style type="text/css">
	
#account-detail-overlay
{
	height: 100%;
	width: 100%;
	position: fixed;
	top:0;
	right: -100vw; 
	z-index: 1;
	transition: right 0.3s linear;

}

#account-detail-overlay.active
{
	right:0;
}

#account-detail
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

</style>

@endsection



@section('body')


<h2>Account</h2>

<div class="row">
	<div class="col-12">
		<div class="card">
			<button class="btn-blue btn-size-form" onclick="toggleOverlay('#account-detail-overlay')"><i class="fas fa-user-plus"></i>Add Account</button>
			<div id="account-table"></div>
		</div>
	</div>
</div>


<div id="account-detail-overlay">
	<div id="account-detail">
		<form  @submit.prevent="handleSubmit">
			@csrf
			<div class="row">
				<div class="offset-2 col-8">
					
					<input type="hidden" name="id" v-model="accountDetail.id">

					<div class="form-group">
						<label for="">Username</label>
						<input type="text" name="username" v-model="accountDetail.username">
					</div>

					<div class="form-group">
						<label for="">Password</label>
						<input type="password" name="password" v-model="accountDetail.password">
					</div>

{{-- 					<div class="form-group">
						<label for="">Confirm Password</label>
						<input type="text" v-model="confirmPassword">
					</div> --}}

					<div class="form-group">
						<label for="">First Name</label>
						<input type="text" name="first_name" v-model="accountDetail.first_name">
					</div>

					<div class="form-group">
						<label for="">Last Name</label>
						<input type="text" name="last_name" v-model="accountDetail.last_name">
					</div>


					<div class="form-group">
						<label for="">Gender</label>
						<select name="username" v-model="accountDetail.username">
							<option value="">Select Gender</option>
							<option value="male">Male</option>
							<option value="female">Female</option>
						</select>
					</div>

					<div class="form-group">
						<label for="">Contact No</label>
						<input type="text" name="contact" v-model="accountDetail.contact">
					</div>

					<div class="form-group">
						<label for="">Email Address</label>
						<input type="text" name="email" v-model="accountDetail.email">
					</div>

					<div class="form-group">
						<label for="">Role</label>
						<select name="role" v-model="accountDetail.role">
							<option value="">Select Role</option>
							<option value="Store Manager">Store Manager</option>
							<option value="Product Manager">Product Manager</option>
							<option value="Sales Assistant">Sales Assistant</option>
						</select>
					</div>

					<button type="submit">Add Account</button>
					<button type="button"  @click="Hide">Close</button>
				</div>
			</div>
		</form>
	</div>

</div>


@endsection


@section('script')
<script>

var deleteIcon = function(cell, formatterParams, onRendered)
{
	return '<i class="fas fa-times" style="color:red;"></i>';
}

var editIcon = function(cell, formatterParams, onRendered)
{
	return '<i class="far fa-edit"></i>';
}

var table = new Tabulator("#account-table",{
	layout: "fitColumns",
	headerFilterPlaceholder: "Search",
	columns:
	[
		{title:"ID", field:"id"},
		{title:"Username", field:"username", headerFilter:true},
		{title:"Name", field:"name", headerFilter:true},
		{title:"Edit", formatter:editIcon, align:"center", tooltip:"Edit", 
			// cellClick(e, cell)
			// {
			// 	accountDetail.accountDetail = cell.getData();
			// 	toggleOverlay('#account-detail-overlay');
			// }
		},
		{title:"Remove", formatter:deleteIcon, align:"center", toottip:"Remove",
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
							Swal.fire(
							{
								type: 'success',
								title: 'Account Successfully Deleted',
							})
						}
					});
			}
		}
		
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
			name:"",
			password: "",
			first_name: "",
			last_name: "",
			gender: "",
			contact: "",
			email:"",
			role:""
		}
	},
	methods:
	{
		handleSubmit(event)
		{
			var formData = new FormData(event.target);
			formAjax("/Account/AddAccount", "POST", formData, function(response){alert(response), alertError});
		},

		Edit()
		{

		},

		Hide()
		{
			this.accountDetail = 
			{
				id:"",
				username:"",
				name:"",
				password: "",
				first_name: "",
				last_name: "",
				gender: "",
				contact: "",
				email:"",
				role:""
			}
			toggleOverlay('#account-detail-overlay')
		},

		manageAccount()
		{
			if(response.Status == "Success")
			{

				SwalSuccess('New account is successfully added.','');
				this.Hide();
				return 0;
			}

			if(response.Status == "Validation Error")
			{
				SwalError('Invalid detail. Please check error messages.','');
				return 0;
			}

			if(response.Status == "Database Error")
			{
				SwalError('Database Error. Please contact administrator.','');
			}
		}
	}
})

</script>

@endsection