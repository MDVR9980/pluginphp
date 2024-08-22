<?php

function check_extensions()
{
	$extensions = 
	[
		'gd',
		'pdo_mysql'
	];

	$not_loaded = [];
	foreach ($extensions as $ext) {
		if(!extension_loaded($ext))
			$not_loaded[] = $ext;
	}

	if(!empty($not_loaded))
		dd("please load the following extensions in your php.ini file: " . implode(",", $not_loaded));

}

check_extensions();
