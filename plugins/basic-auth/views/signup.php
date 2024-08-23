<link rel="stylesheet" type="text/css" href="<?=plugin_http_path('assets/css/style.css')?>">

<main class="p-4" style="background-color: #dde5f4;">
	
	<form method="post" class="col-xl-3 col-lg-4 col-md-6 col-sm-8 mx-auto p-4 shadow" style="border-radius: 40px;background-color: #f1f7fe">
 
 		<?= csrf()?>
 		
		<h3 class="text-center mt-2">Signup</h3>
		<div class="mb-4 text-muted text-center"><i>Please enter your details</i></div>
 
		<div class="form-floating my-2">
		  <input value="<?=old_value('first_name')?>" name="first_name" type="text" class="form-control" id="floatingInput" placeholder="name@example.com"  style="border-radius: 40px;">
		  <label for="floatingInput">First Name</label>

		  	<?php if(!empty($errors['first_name'])):?>
			  <small class="text-danger px-2"><?=$errors['first_name']?></small>
			<?php endif?>
		</div>

		<div class="form-floating my-2">
		  <input value="<?=old_value('last_name')?>" name="last_name" type="text" class="form-control" id="floatingInput" placeholder="name@example.com"  style="border-radius: 40px;">
		  <label for="floatingInput">Last Name</label>

		  	<?php if(!empty($errors['last_name'])):?>
			  <small class="text-danger px-2"><?=$errors['last_name']?></small>
			<?php endif?>
		</div>
		
		<select class="form-select p-3" name="gender" style="border-radius: 40px;">
			<option value="">--Select Gender--</option>
			<option <?=old_select('gender','male')?> value="male">Male</option>
			<option <?=old_select('gender','female')?> value="female">Female</option>
		</select>
		<?php if(!empty($errors['gender'])):?>
		  <small class="text-danger px-2"><?=$errors['gender']?></small>
		<?php endif?>

		<div class="form-floating my-2">
		  <input value="<?=old_value('email')?>" name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com"  style="border-radius: 40px;">
		  <label for="floatingInput">Email address</label>

		  	<?php if(!empty($errors['email'])):?>
			  <small class="text-danger px-2"><?=$errors['email']?></small>
			<?php endif?>
		</div>
		
		<div class="form-floating my-2">
		  <input value="<?=old_value('password')?>" name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password"  style="border-radius: 40px;">
		  <label for="floatingPassword">Password</label>

		  	<?php if(!empty($errors['password'])):?>
			  <small class="text-danger px-2"><?=$errors['password']?></small>
			<?php endif?>
		</div>
		
		<div class="form-floating my-2">
		  <input value="<?=old_value('retype_password')?>" name="retype_password" type="password" class="form-control" id="floatingPassword" placeholder="Password"  style="border-radius: 40px;">
		  <label for="floatingPassword">Retype Password</label>
		</div>

		<div class="px-2 d-flex justify-content-between">
			<a href="<?=ROOT?>/<?=$vars['forgot_page']?>">Forgot password?</a>
			<a href="<?=ROOT?>/<?=$vars['login_page']?>">or Login</a>
		</div>
		<button class="btn text-white px-4 py-3 w-100 my-4" style="border-radius: 40px;background-color: #3d4785">Signup</button>
	</form>

</main>

<script src="<?=plugin_http_path('assets/js/plugin.js')?>"></script>