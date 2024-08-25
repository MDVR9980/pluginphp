<div class="table-responsive">
	<table class="table table-striped table-bordered">
		<tr>
			<th>#</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Image</th>
			<th>Gender</th>
			<th>Roles</th>
			<th>Date Created</th>
			<th>Date Updated</th>
			<th>
				<bottom class="btn btn-bd-primary btn-sm">
					<i class="fa-solid fa-plus"></i> Add New
				</bottom>
			</th>
		</tr>

		<?php if(!empty($rows)):?>
			<?php foreach($rows as $row):?>
				<tr>
					<td>#</td>
					<td><?=esc($row->first_name)?></td>
					<td><?=esc($row->last_name)?></td>
					<td>
						<img src="<?=get_image($row->image)?>" class="img-thumbnail" style="width=80px;height:80px;object-fit: cover"/>
					</td>
					<td><?=esc($row->gender)?></td>
					<td>Roles</td>
					<td><?=get_date($row->date_created)?></td>
					<td><?=get_date($row->date_updated)?></td>
					<td>
						<bottom class="btn btn-warning btn-sm">
							<i class="fa-solid fa-pen-to-square"></i> Edit
						</bottom>
						<bottom class="btn btn-danger btn-sm">
							<i class="fa-solid fa-trash"></i> Delete
						</bottom>
					</td>
				</tr>
			<?php endforeach ?>
		<?php endif ?>
	</table>
</div>