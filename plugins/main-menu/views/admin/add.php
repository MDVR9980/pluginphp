<?php if(user_can('add_menu_page')):?>
	
	<form method="post" enctype="multipart/form-data">
		
		<div class="row g-3 col-md-6 mx-auto shadow p-4 rounded">
		
		<?=csrf()?>

		<h4 class="text-center">New Record</h4>
		<div class="d-flex justify-content-around">
			<label class="text-center">
				Image:<br>
				<img src="<?=get_image('')?>" class="img-thumbnail" style="cursor:pointer;width:100%;max-width:200px;max-height: 200px;object-fit: cover;">
				<input onchange="display_image(event)" type="file" name="image" class="d-none">

				<?php if(!empty($errors['image'])):?>
				  <small class="text-danger"><?=$errors['image']?></small>
				<?php endif?>
			</label>
			
			<label class="text-center">
				Mega Image:<br>
				<img src="<?=get_image('')?>" class="img-thumbnail" style="cursor:pointer;width:100%;max-width:200px;max-height: 200px;object-fit: cover;">
				<input onchange="display_mega_image(event)" type="file" name="mega_image" class="d-none">

				<?php if(!empty($errors['image'])):?>
				  <small class="text-danger"><?=$errors['image']?></small>
				<?php endif?>
			</label>
		</div>
		<div class="mb-1 col-md-12">
		  <input autofocus name="title" value="<?=old_value('title')?>" type="text" class="form-control" id="title" placeholder="Title">
			
			<?php if(!empty($errors['title'])):?>
			  <small class="text-danger"><?=$errors['title']?></small>
			<?php endif?>
		</div>

		<div class="mb-1 col-md-12">
		  <input autofocus name="slug" value="<?=old_value('slug')?>" type="text" class="form-control" id="slug" placeholder="Item slug/link">
			
			<?php if(!empty($errors['slug'])):?>
			  <small class="text-danger"><?=$errors['slug']?></small>
			<?php endif?>
		</div>

		<div class="mb-1 col-md-6">
		  <label for="icon" class="form-label">Icon</label>
		  <input name="icon" value="<?=old_value('icon')?>" type="text" class="form-control" id="icon" placeholder="Icon class names">
			
			<?php if(!empty($errors['icon'])):?>
			  <small class="text-danger"><?=$errors['icon']?></small>
			<?php endif?>
		</div>
		
		<div class="mb-1 col-md-6">
		  <label for="permission" class="form-label">Permission</label>
		  <input name="permission" value="<?=old_value('permission')?>" type="text" class="form-control" id="last_name" placeholder="User Permission">
		
			<?php if(!empty($errors['permission'])):?>
			  <small class="text-danger"><?=$errors['permission']?></small>
			<?php endif?>
		</div>

		<div class="mb-1 col-md-12">
			<label for="email" class="form-label">Parent</label>
			
			<select class="form-select" name="parent">
			  <option value="0">--Select Parent--</option>
			  	
			  	<?php if(!empty($all_items)):?>
				  	<?php foreach($all_items as $item):?>
				  		<option <?=old_select('parent',$item->id)?> value="<?=$item->id?>"><?=$item->title?></option>
					<?php endforeach?>
				<?php endif?>
			</select>

			<?php if(!empty($errors['parent'])):?>
			  <small class="text-danger"><?=$errors['parent']?></small>
			<?php endif?>
		</div>

		<div class="mb-1 col-md-6">
			<label for="" class="form-label">Is this a Mega Menu?</label>
			<select class="form-select" name="is_mega">
				<option value="0">--Select--</option>
			  	<option <?=old_select('is_mega','1')?> value="1">Yes</option>
			  	<option <?=old_select('is_mega','0')?> value="0">No</option>
			</select>

		</div>
 
		<div class="mb-1 col-md-6">
			<label for="" class="form-label">Active</label>
			<select class="form-select" name="disabled">
			  <option <?=old_select('disabled','0')?> value="0">Yes</option>
			  <option <?=old_select('disabled','1')?> value="1">No</option>
			</select>

		</div>
 
		<div class="d-flex justify-content-between">
			<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>">
				<button type="button" class="btn btn-primary">
					<i class="fa-solid fa-chevron-left"></i> Back
				</button>
			</a>
			<button class="btn btn-danger">
				<i class="fa-solid fa-save"></i> Save
			</button>
		</div>
	</div>
	</form>

	<script type="text/javascript">

		var valid_image = true;
		function display_image(e)
		{
			let allowed = ['image/jpeg','image/png','image/webp'];
			let file = e.currentTarget.files[0];

			if(!allowed.includes(file.type)){
				alert("Only files of this type allowed: " + allowed.toString().replaceAll('image/',''));
				valid_image = false;
				return;
			}
			valid_image = true;
			e.currentTarget.parentNode.querySelector('img').src = URL.createObjectURL(file);
		}

		function submit_form(e)
		{
			if(!valid_image)
			{
				e.preventDefault()
				alert("Please add a valid image");
				return;
			}
		}

	</script>

<?php else:?>
	<div class="alert alert-danger text-center">
		Access denied. You dont have permission for this action
	</div>
<?php endif?>