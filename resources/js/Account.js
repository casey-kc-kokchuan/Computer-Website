

var deleteIcon = function(cell, formatterParams, onRendered)
{
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
	data: data,
	headerFilterPlaceholder: "Search",
	responsiveLayout:"collapse",
	responsiveLayoutCollapseStartOpen:false,
	columns:
	[
		{formatter:"responsiveCollapse", width:50, minWidth:30, align:"center", headerSort:false,resizable:false, responsive:0},
		{title:"ID", field:"id", responsive: 0},
		{title:"Username", field:"username", headerFilter:true, responsive: 0},
		{title:"Full Name", field:"full_name", headerFilter:true, responsive: 1},
		{title:"Role", field:"role", headerFilter:true,responsive: 1},
		{title:"Gender", field:"gender", headerFilter:true, responsive: 1},
		{title:"Contact No", field:"contact", headerFilter:true, responsive: 1},
		{title:"Email", field:"email", headerFilter:true,responsive: 1},
		{title:"Edit", formatter:editIcon, align:"center", tooltip:"Edit", responsive: 0,
			cellClick(e, cell)
			{
				var obj = {};
				Object.assign(obj, cell.getData())
				accountDetail.accountDetail = obj;
				accountDetail.isEdit = true;
				toggleOverlay('#account-detail-overlay');
			}
		},
		{title:"Remove", formatter:deleteIcon, align:"center", tooltip:"Remove",responsive: 0,
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
										table.setData(response.Data);
										return 0;
									}


									if(response.Status == "Database Error")
									{
										SwalError('Database Error. Please contact administrator.','');
									}

								}, alertError );

						}
					});
				
			}
		},
		// {title:"Change Password", formatter:passwordIcon, align:"center", tooltip:"Change Password",cellClick(e, cell)
		// 	{
		// 		(
		// 		async function getFormValues () 
		// 		{
		// 			const {value: formValues} = await Swal.fire(
		// 			{
		// 			  title: 'Change Password',
		// 			  html:
		// 			    '<input type="password" id="password" class="swal2-input" placeholder="Password">' + 
		// 			    '<input type="password" id="confirmPassword" class="swal2-input" placeholder="Confirm Password">' +
		// 			    '<p id="err" class="text-danger"></p>' ,
		// 			  focusConfirm: false,
		// 			  showCancelButton:true,
		// 			  cancelButtonColor:'#d9534f',
		// 			  cancelButtonText: "No",
		// 			  confirmButtonColor:'#5cb85c',
		// 			  confirmButtonText: 'Save',
		// 			  preConfirm: ()=>
		// 			  {
		// 			  	let password = document.getElementById('password').value;
		// 			  	let confirmPassword = document.getElementById('confirmPassword').value;

		// 			  	if( password && confirmPassword)
		// 			  	{

		// 			  		if(password.length < 8 || password.length > 255)
		// 			  		{
		// 			  			document.getElementById('err').innerHTML = "The password must be between 8 and 255 characters.";
		// 			  		}
		// 			  		else
		// 			  		{
		// 			  			if(password == confirmPassword)
		// 			  			{
					  				
		// 			  				return {
		// 			  					id: cell.getData().id,
		// 			  					password: password
		// 			  				}
		// 			  			}
		// 			  			else
		// 			  			{
		// 			  				document.getElementById('err').innerHTML = "Password does not match.";
		// 			  				document.getElementById('password').value  = "";
		// 			  				document.getElementById('confirmPassword').value  = "";
		// 			  			}
		// 			  		}

		// 			  	}	
		// 			  	else
		// 			  	{
		// 			  		document.getElementById('err').innerHTML = "Both field is required.";
		// 			  	}
		// 			    return false;
		// 			  }
		// 			})

		// 			if (formValues) 
		// 			{

		// 				jsonAjax("/Account/ChangePassword", "POST", JSON.stringify(formValues) ,function(response)
		// 					{
		// 						if(response.Status == "Success")
		// 						{

		// 							SwalSuccess('Password is successfully changed.','');
		// 							return 0;
		// 						}

		// 						if(response.Status == "Validation Error")
		// 						{
		// 							SwalError('Validation Error' ,response.Message.password[0]);
		// 							return 0;
		// 						}

		// 						if(response.Status == "Database Error")
		// 						{
		// 							SwalError('Database Error. Please contact administrator.','');
		// 						}
		// 					}
		// 					,alertError);

		// 			}
		// 		})()
		// 	}
		// },
		
	],
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
