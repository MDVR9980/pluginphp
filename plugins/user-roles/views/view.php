<?php if(user_can('view_user_details')):?>

	<?php if(!empty($row)):?>

			
			<div class="row g-3 col-md-6 mx-auto shadow p-4 rounded">
			

			<h4 class="text-center">View Record</h4>
 
			<div class="mb-3 col-md-6">
			  <label for="role" class="form-label">Role</label>
			  <div class="form-control"><?=esc($row->role)?></div>
			</div>
 
			<div class="mb-3 col-md-6">
				<label for="disabled" class="form-label">Active</label>
				<div class="form-control"><?=esc($row->disabled ? 'No':'Yes')?></div>
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