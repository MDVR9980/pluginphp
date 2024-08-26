<?php if(user_can('view_roles')):?>

<form method="post">

	<?=csrf()?>
	<div class="table-responsive">
		<table class="table table-striped table-bordered">
			<tr>
				<th>#</th>
				<th>Role</th>
				<th>Active</th>
				<th>
					<div class="d-flex justify-content-between">
						Permissions
						<button class="btn btn-bd-primary btn-sm">
							<i class="fa-solid fa-save"></i> Save Permissions
						</button>
					</div>
				</th>
				<th>
					<?php if(user_can('add_role')):?>
					<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>/add">
						<button type="button" class="btn btn-bd-primary btn-sm">
							<i class="fa-solid fa-plus"></i> Add New
						</button>
					</a>
					<?php endif?>
				</th>
			</tr>

			<?php if(!empty($rows)):?>
				<?php foreach($rows as $row):?>
					<tr>
						<td><?=$row->id?></td>
						<td>
							<?=esc($row->role)?>
						</td>
						<td>
							<?=esc($row->disabled ? 'No':'Yes')?>
						</td>

						<td style="max-width:200px">
							<div class="row g-2">
								<?php $perms = array_unique(APP('permissions')); ?>

								<?php if(!empty($perms)):$num = 0?>
									<?php foreach($perms as $perm):$num++?>
										<div class="form-check col-md-6">
										  <input <?=in_array($perm, $row->permissions ?? []) ? ' checked ':''?> name="checkbox_<?=$row->id?>_<?=$num?>" class="form-check-input" type="checkbox" value="<?=$perm?>" id="checkbox_<?=$row->id?>_<?=$num?>">
										  <label class="form-check-label" for="checkbox_<?=$row->id?>_<?=$num?>" style="cursor:pointer;">
										    <?=esc(str_replace("_", " ", $perm))?>
										  </label>
										</div>
									<?php endforeach?>
								<?php endif?>
							</div>
						</td>
						<td>
	 
							<?php if(user_can('edit_role')):?>
							<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>/edit/<?=$row->id?>">
								<button type="button" class="btn btn-warning btn-sm">
									<i class="fa-solid fa-pen-to-square"></i> Edit
								</button>
							</a>
							<?php endif?>

							<?php if(user_can('delete_role')):?>
							<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>/delete/<?=$row->id?>">
								<button type="button" class="btn btn-danger btn-sm">
									<i class="fa-solid fa-trash"></i> Delete
								</button>
							</a>
							<?php endif?>
						</td>
					</tr>
				<?php endforeach?>
			<?php endif?>
		</table>
	</div>
</form>

<?php else:?>
	<div class="alert alert-danger text-center">
		Access denied. You dont have permission for this action
	</div>
<?php endif?>