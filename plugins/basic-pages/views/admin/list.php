<?php if(user_can('view_pages')):?>

<div class="table-responsive">

	<label><i>Page: <?=$pager->page_number?></i></label>

	<form class="input-group my-3 mx-auto" >
	  <input placeholder="Search by Title" type="text" class="form-control" value="<?=old_value('find','','get')?>" name="find" autofocus="true">
	  <button class="input-group-text bg-primary text-white" id="basic-addon1">
	  	Search
	  </button>
	</form>

	<table class="table table-striped table-bordered">
		<tr>
			<th>#</th>
			<th>Title</th>
			<th>Author</th>
			<th>Image</th>
			<th>Views</th>
			<th>Active</th>
			<th>Slug</th>
			<th>Categories</th>
			<th>Date Created</th>
			<th>
				<?php if(user_can('add_page')):?>
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
						<a target="_blank" href="<?=ROOT?>/<?=$row->slug?>">
							<?=esc($row->title)?>
						</a>
					</td>
					<td>
						<?php if(!empty($row->user_row)):?>
							<a href="<?=ROOT?>/admin/users/view/<?=$row->user_row->id?>">
								<?=$row->user_row->first_name?> <?=$row->user_row->last_name?>
							</a>
						<?php else:?>	
							<?='Unknown'?>
						<?php endif?>	
					</td>
					<td>
						<img src="<?=get_image($row->image)?>" class="img-thumbnail" style="width:80px;height:80px;object-fit: cover;"/>
					</td>
					<td><?=$row->views?></td>
					<td><?=$row->disabled ? 'No':'Yes'?></td>
					<td><?=esc($row->slug)?></td>
					<td>
						<?php if(!empty($row->category_rows)):?>
							<?php foreach($row->category_rows as $cat):?>
								<div><i><?=esc($cat->category)?></i></div>
							<?php endforeach?>
						<?php endif?>
					</td>
					<td><?=get_date($row->date_created)?></td>
					<td>
						<?php if(user_can('view_pages')):?>
						<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>/view/<?=$row->id?>">
							<button class="btn btn-primary btn-sm">
								<i class="fa-solid fa-eye"></i> View
							</button>
						</a>
						<?php endif?>

						<?php if(user_can('edit_page')):?>
						<a href="<?=ROOT?>/<?=$admin_route?>/<?=$plugin_route?>/edit/<?=$row->id?>">
							<button class="btn btn-warning btn-sm">
								<i class="fa-solid fa-pen-to-square"></i> Edit
							</button>
						</a>
						<?php endif?>

						<?php if(user_can('delete_page')):?>
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