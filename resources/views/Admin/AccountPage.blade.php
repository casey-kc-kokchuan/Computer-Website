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


					<button type="submit" class="btn-blue btn-size-form2" style="width:100%" v-if="isEdit">Update</button>
					<button type="submit" class="btn-green btn-size-form2" style="width:100%" v-else>Add</button>
				</form>
			</div>
		</div>
	</div>

</div>


@endsection


@section('script')
<script type="text/javascript">
	var data = {!! json_encode($Data) !!};
</script>
<script type="text/javascript" src={{ URL::asset('js/Account.js')}}></script>

@endsection