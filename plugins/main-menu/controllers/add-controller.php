<?php

	$postdata = $req->post();
	$filedata = $req->files();

	$files_ok = true;
	if(!empty($filedata)) {
		$postdata['image'] = $req->upload_files('image');
		if(!empty($req->upload_errors))
			$files_ok = false;
	}
	
	$csrf = csrf_verify($postdata);
	if($csrf && $files_ok && $menu->validate_insert($postdata)) {
		if(user_can('add_menu_page')) {

			$menu->insert($postdata);
			
			message_success("Record added successfully!");
			redirect($admin_route.'/'.$plugin_route.'/view/'.$menu->insert_id);
		}
	}

	if(!$csrf)
		$menu->errors['email'] = "Form expired!";
	
	set_value('errors',$menu->errors);

