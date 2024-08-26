<?php if(user_can('view_pages')):?>

	<?php if(!empty($row)):?>
			
			<div class="row g-3">

			<h4 class="text-center">View Record</h4>
			<div class="row">
				<h3 class="p-0"><?=esc($row->title)?></h3>
				<?php if($row->display_featured_image):?>
					<label class="text-center">
						<img src="<?=get_image($row->image)?>" class="" style="width:100%;max-height: 300px;object-fit: cover;">
						<hr>
					</label>
				<?php endif?>
				<?=($row->content)?>
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