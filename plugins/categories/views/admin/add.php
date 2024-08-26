<?php if(user_can('add_category')):?>
	
	<form method="post" enctype="multipart/form-data">
		
		<div class="row g-3 col-md-6 mx-auto shadow p-4 rounded">
		
		<?=csrf()?>

		<h4 class="text-center">New Record</h4>
		
		<div class="mb-3 col-md-6">
		  <label for="category" class="form-label">Category Name</label>
		  <input name="category" value="<?=old_value('category')?>" type="text" class="form-control" id="category" placeholder="Enter Category Name">
			
			<?php if(!empty($errors['category'])):?>
			  <small class="text-danger"><?=$errors['category']?></small>
			<?php endif?>
		</div>

		<div class="mb-3 col-md-6">
		  <label for="slug" class="form-label">Slug</label>
		  <input name="slug" value="<?=old_value('slug')?>" type="text" class="form-control" id="slug" placeholder="URL friendly name(optional)">
			
			<?php if(!empty($errors['slug'])):?>
			  <small class="text-danger"><?=$errors['slug']?></small>
			<?php endif?>
		</div>
 
		<div class="mb-3 col-md-6">
			<label for="disabled" class="form-label">Active</label>
			<select class="form-select" name="disabled">
			  <option <?=old_select('disabled','0')?> value="0">Yes</option>
			  <option <?=old_select('disabled','1')?> value="1">No</option>
			</select>

			<?php if(!empty($errors['disabled'])):?>
			  <small class="text-danger"><?=$errors['disabled']?></small>
			<?php endif?>
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

<?php else:?>
	<div class="alert alert-danger text-center">
		Access denied. You dont have permission for this action
	</div>
<?php endif?>