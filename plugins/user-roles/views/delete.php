<?php if(user_can('delete_role')):?>

	<?php if(!empty($row)):?>

			<form method="post" enctype="multipart/form-data">
				
				<div class="row g-3 col-md-6 mx-auto shadow p-4 rounded">
				
				<?=csrf()?>

				<h4 class="">Delete Record</h4>
				<div class="alert alert-danger text-center">Are you sure you want to delete this record?!</div>
 
				<div class="mb-3 col-md-6">
				  <label for="role" class="form-label">Role</label>
				  <div class="form-control"><?=esc($row->role)?></div>
				</div>
 
				<div class="mb-3 col-md-6">
					<label for="email" class="form-label">Active</label>
					<div class="form-control"><?=esc($row->disabled ? 'No':'Yes')?></div>
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