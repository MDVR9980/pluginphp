<link rel="stylesheet" type="text/css" href="<?=plugin_http_path('assets/css/style.css')?>">

<div class="row col-md-10 p-4 mx-auto shadow">
	<h3 class="p-0"><?=esc($row->title)?></h3>
	<?php if($row->display_featured_image):?>
		<label class="text-center">
			<img src="<?=get_image($row->image)?>" class="" style="width:100%;max-height: 300px;object-fit: cover;">
			<hr>
		</label>
	<?php endif?>
	<?=($row->content)?>

	<?php
		do_action('basic-posts-show_posts',['row'=>$row]);

/*	require class_path('basic-posts', 'Post');
	$post = new \BasicPosts\Post;

	dd($post);*/
	?>
</div>

<script src="<?=plugin_http_path('assets/js/plugin.js')?>"></script>