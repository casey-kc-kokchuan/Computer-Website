<template>
	
	<form action="/Admin" method="POST">
		@csrf
		
			
			<div class="offset-2 col-8">
				<input type="hidden" name="id" value="">

				<div class="form-group">
					<img src="#" id="img" style="height:200px;width:200px;">	
					<input type="file" name="img" onchange="previewImg(this)">
				</div>

				<div class="form-group">
					<label for="name">Name</label>	
					<input type="text" name="name" class="form-control">
				</div>

				<div class="form-group">
					<label for="name">Name</label>	
					<input type="text" name="name" class="form-control">
				</div>

				<div class="form-group">
					<label for="type">Type</label>	
					<select name="type" class="form-control">
						<option value="">Select Type</option>
					</select>
				</div>

				<div class="form-group">
					<label for="brand">Brand</label>
					<select name="type" class="form-control">
						<option value="">Select Brand</option>
					</select>	
				</div>

				<div class="form-group">
					<label for="">Price</label>	
					<input type="text" name="" class="form-control">
				</div>

				<div class="form-group">
					<label for="">Qty in Stock</label>	
					<input type="text" name="qty" class="form-control">
				</div>

				<button type="submit">Submit</button>
			</div>

	</form>	
</template>