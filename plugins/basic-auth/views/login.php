<link rel="stylesheet" type="text/css" href="<?=plugin_http_path('assets/css/style.css')?>">

<main class="p-4" style="background-color: #dde5f4;">
	
	<form method="post" class="col-xl-3 col-lg-4 col-md-6 col-sm-8 mx-auto p-4 rshadow" style="border-radius: 40px;background-color: #f1f7fe">
		
		<?= csrf()?>
		
		<div class="text-center">
			<svg fill="#3d4785" style="border-radius: 50%;" width="80" height="80" viewBox="0 0 24 24"><path d="M19 7.001c0 3.865-3.134 7-7 7s-7-3.135-7-7c0-3.867 3.134-7.001 7-7.001s7 3.134 7 7.001zm-1.598 7.18c-1.506 1.137-3.374 1.82-5.402 1.82-2.03 0-3.899-.685-5.407-1.822-4.072 1.793-6.593 7.376-6.593 9.821h24c0-2.423-2.6-8.006-6.598-9.819z"/></svg>
		</div>

		<h3 class="text-center mt-4">Login</h3>
		<div class="mb-4 text-muted text-center"><i>please login to continue</i></div>

		<?php if(message_success()):?>
			<div class="alert alert-success text-center">
				<?=esc(message_success('',true))?>
			</div>
		<?php endif?>
		<?php if(message_fail()):?>
			<div class="alert alert-danger text-center">
				<?=esc(message_fail('',true))?>
			</div>
		<?php endif?>
		

		<div class="form-floating my-4">
		  <input value="<?=old_value('email')?>" name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com"  style="border-radius: 40px;">
		  <label for="floatingInput">Email address</label>
		</div>
		<div class="form-floating my-4">
		  <input value="<?=old_value('password')?>" name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password"  style="border-radius: 40px;">
		  <label for="floatingPassword">Password</label>
		</div>

		<div class="px-2 d-flex justify-content-between">
			<a href="<?=ROOT?>/<?=$vars['forgot_page']?>">Forgot password?</a>
			<a href="<?=ROOT?>/<?=$vars['signup_page']?>">or Signup</a>
		</div>
		<button class="btn text-white px-4 py-3 w-100 my-4" style="border-radius: 40px;background-color: #3d4785">Login</button>
	</form>

</main>

<script src="<?=plugin_http_path('assets/js/plugin.js')?>"></script>