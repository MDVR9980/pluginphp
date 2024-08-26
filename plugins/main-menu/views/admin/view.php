<?php if(user_can('view_user_details')):?>

	<?php if(!empty($row)):?>

			
		<div class="row g-3 col-md-6 mx-auto shadow p-4 rounded">
			

			<h4 class="text-center">View Record</h4>
			<div class="d-flex justify-content-around">
				<label class="text-center">
					Image:<br>
					<img src="<?=get_image($row->image)?>" class="img-thumbnail" style="cursor:pointer;width:100%;max-width:200px;max-height: 200px;object-fit: cover;">

				</label>
				
				<label class="text-center">
					Mega Image:<br>
					<img src="<?=get_image($row->mega_image)?>" class="img-thumbnail" style="cursor:pointer;width:100%;max-width:200px;max-height: 200px;object-fit: cover;">

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
 			
 			<div class="mb-1 col-md-6">
			  <div class="form-control">Parent: <?=esc($row->parent)?></div>
			</div>
			<div class="mb-1 col-md-6">
			  <div class="form-control">LIst order: <?=esc($row->list_order)?></div>
			</div>
			
 			<div class="mb-1 col-md-6">
			  <div class="form-control">Is Mega Menu: <?=($row->is_mega) ? 'Yes':'No'?></div>
			</div>
 			<div class="mb-1 col-md-6">
			  <div class="form-control">Active: <?=($row->disabled) ? 'No':'Yes'?></div>
			</div>

			<div class="d-flex justify-content-between">
				<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>">
					<button class="btn btn-primary">
						<i class="fa-solid fa-chevron-left"></i> Back
					</button>
				</a>
				<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>/edit/<?=$row->id?>">
					<button class="btn btn-warning">
						<i class="fa-solid fa-pen-to-square"></i> Edit
					</button>
				</a>
				<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>/delete/<?=$row->id?>">
					<button class="btn btn-danger">
						<i class="fa-solid fa-trash"></i> Delete
					</button>
				</a>
				

			</div>
		</div>

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