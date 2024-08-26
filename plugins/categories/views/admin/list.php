<?php if(user_can('view_categories')):?>

<div class="table-responsive">

	<label><i>Page: <?=$pager->page_number?></i></label>

	<form class="input-group my-3 mx-auto" >
	  <input placeholder="Search by Name" type="text" class="form-control" value="<?=old_value('find','','get')?>" name="find" autofocus="true">
	  <button class="input-group-text bg-primary text-white" id="basic-addon1">
	  	Search
	  </button>
	</form>

	<table class="table table-striped table-bordered">
		<tr>
			<th>#</th>
			<th>Category Name</th>
			<th>Slug</th>
			<th>Active</th>

			<th>
				<?php if(user_can('add_category')):?>
				<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>/add">
					<button class="btn btn-bd-primary btn-sm">
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
						<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>/view/<?=$row->id?>">
							<?=esc($row->category)?>
						</a>
					</td>

					<td><?=esc($row->slug)?></td>
					<td><?=($row->disabled) ? 'No':'Yes'?></td>

					<td>
						<?php if(user_can('view_category_details')):?>
						<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>/view/<?=$row->id?>">
							<button class="btn btn-primary btn-sm">
								<i class="fa-solid fa-eye"></i> View
							</button>
						</a>
						<?php endif?>

						<?php if(user_can('edit_category')):?>
						<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>/edit/<?=$row->id?>">
							<button class="btn btn-warning btn-sm">
								<i class="fa-solid fa-pen-to-square"></i> Edit
							</button>
						</a>
						<?php endif?>

						<?php if(user_can('delete_category')):?>
						<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>/delete/<?=$row->id?>">
							<button class="btn btn-danger btn-sm">
								<i class="fa-solid fa-trash"></i> Delete
							</button>
						</a>
						<?php endif?>
					</td>
				</tr>
			<?php endforeach?>
		<?php endif?>
	</table>

	<?=$pager->display()?>

</div>
<?php else:?>
	<div class="alert alert-danger text-center">
		Access denied. You dont have permission for this action
	</div>
<?php endif?>