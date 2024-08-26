<?php if(user_can('delete_user')):?>

	<?php if(!empty($row)):?>

			<form method="post" enctype="multipart/form-data">
				
				<div class="row g-3 col-md-6 mx-auto shadow p-4 rounded">
				
				<?=csrf()?>

				<h4 class="">Delete Record</h4>
				<div class="alert alert-danger text-center">Are you sure you want to delete this record?!</div>
				
				<div class="d-flex justify-content-around">
					<label class="text-center">
						Image:<br>
						<img src="<?=get_image('')?>" class="img-thumbnail" style="cursor:pointer;width:100%;max-width:200px;max-height: 200px;object-fit: cover;">
						<input onchange="display_image(event)" type="file" name="image" class="d-none">

					</label>
					
					<label class="text-center">
						Mega Image:<br>
						<img src="<?=get_image('')?>" class="img-thumbnail" style="cursor:pointer;width:100%;max-width:200px;max-height: 200px;object-fit: cover;">
						<input onchange="display_mega_image(event)" type="file" name="mega_image" class="d-none">

					</label>
				</div>
				<div class="mb-1 col-md-12 form-control">
				  Title: <?=esc($row->title)?>
				</div>
				<div class="mb-1 col-md-12 form-control">
				  Slug: <?=esc($row->slug)?>
				</div>
				<div class="mb-1 col-md-6">
				  <div class="form-control">Icon: <?=esc($row->icon)?></div>
				</div>
	 			<div class="mb-1 col-md-6">
				  <div class="form-control">Permission: <?=esc($row->permission)?></div>
				</div>
	 			
	 			<div class="mb-1 col-md-12">
				  <div class="form-control">Parent: <?=esc($row->parent)?></div>
				</div>
	 			<div class="mb-1 col-md-6">
				  <div class="form-control">Is Mega Menu: <?=($row->is_mega) ? 'Yes':'No'?></div>
				</div>
	 			<div class="mb-1 col-md-6">
				  <div class="form-control">Active: <?=($row->disabled) ? 'No':'Yes'?></div>
				</div>

	 
				<div class="d-flex justify-content-between">
					<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>">
						<button type="button" class="btn btn-primary">
							<i class="fa-solid fa-chevron-left"></i> Back
						</button>
					</a>
					<button class="btn btn-danger">
						<i class="fa-solid fa-save"></i> Delete
					</button>
				</div>
			</div>
		</form>

	<?php else:?>
		<div class="alert alert-danger text-center">
			That record was not found!
		</div>
		
		<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>">
			<button class="btn btn-primary">Back</button>
		</a>
	<?php endif?>

<?php else:?>
	<div class="alert alert-danger text-center">
		Access denied. You dont have permission for this action
	</div>
<?php endif?>