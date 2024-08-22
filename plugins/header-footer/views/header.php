<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="<?=ROOT?>/assets/css/bootstrap.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=ucfirst(page())?> | <?=APP_NAME?></title>
</head>
<body>

	<div class="col-md-10 mx-auto p-4">
		<?php if(!empty($links)):?>
			<?php foreach($links as $link):?>
				<a href="<?=ROOT?>/<?=$link->slug?>"><?=$link->title?></a>
			<?php endforeach?>
		<?php endif?>
	</div>

