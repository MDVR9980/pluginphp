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

				<?php if(user_can($link->permission)):?>
					<a href="<?=ROOT?>/<?=$link->slug?>"><?=$link->title?></a>
				<?php endif?>
			<?php endforeach?>
		<?php endif?>
	</div>