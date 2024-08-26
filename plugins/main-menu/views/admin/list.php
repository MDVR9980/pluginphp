<?php if(user_can('view_menu_pages')):?>

<div class="table-responsive">

	<form class="input-group mb-2 mx-auto" >
	  <input placeholder="Search by title" type="text" class="form-control" value="<?=old_value('find','','get')?>" name="find" autofocus="true">
	  <button class="input-group-text bg-primary text-white" id="basic-addon1">
	  	Search
	  </button>
	</form>
 
	<table class="table table-striped table-bordered">
		<tr>
			<th>#</th>
			<th>Order</th>
			<th>Title</th>
			<th>Parent</th>
			<th>Is Mega</th>
			<th>Image</th>
			<th>Mega Image</th>
			<th>Active</th>
			<th>Permission</th>
			<th>Slug</th>
			<th>
				<?php if(user_can('add_menu_page')):?>
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
					<td><?=$row->list_order?></td>
					<td>
						<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>/view/<?=$row->id?>">
							<?=esc($row->title)?>
						</a>
					</td>
					<td>
						<?php if(!empty($row->parent)):?>
							<?=esc($row->parent)?>
						<?php endif?>
					</td>
					<td><?=($row->is_mega) ? 'Yes':'No'?></td>
					<td>
						<img src="<?=get_image($row->image)?>" class="img-thumbnail" style="width:80px;height:80px;object-fit: cover;"/>
					</td>
					<td>
						<img src="<?=get_image($row->mega_image)?>" class="img-thumbnail" style="width:80px;height:80px;object-fit: cover;"/>
					</td>
					
					<td><?=($row->disabled) ? 'No':'Yes'?></td>
					<td><?=esc($row->permission)?></td>
					<td><?=esc($row->slug)?></td>
					<td>
						<?php if(user_can('view_menu_page')):?>
						<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>/view/<?=$row->id?>">
							<button class="btn btn-primary btn-sm">
								<i class="fa-solid fa-eye"></i> View
							</button>
						</a>
						<?php endif?>

						<?php if(user_can('edit_menu_page')):?>
						<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>/edit/<?=$row->id?>">
							<button class="btn btn-warning btn-sm">
								<i class="fa-solid fa-pen-to-square"></i> Edit
							</button>
						</a>
						<?php endif?>

						<?php if(user_can('delete_menu_page')):?>
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