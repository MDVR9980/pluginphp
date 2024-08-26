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
	if($csrf && $files_ok && $user->validate_insert($postdata)) {
		if(user_can('add_user')) {
			$postdata['password'] = password_hash($postdata['password'], PASSWORD_DEFAULT);
			$postdata['date_created'] = date("Y-m-d H:i:s");
			
			$user->insert($postdata);
			
			$user_id = $user->insert_id;

			/** save user roles **/
			if(user_can('edit_role')) {
				$roledata = [];
				
				foreach ($postdata as $key => $role_id) {
					
					if(!strstr($key, "role_"))
						continue;

					$roledata[] = $role_id;
				}
	 			
	 			/** disable all roles **/
	 			$user_roles_map->query('update '.$vars['optional_tables']['roles_map_table'] .' set disabled = 1 where user_id = :user_id',['user_id'=>$user_id]);
	 			
	 			/** saved to database **/
	 			foreach ($roledata as $role_id) {
 
					$user_roles_map->insert([
						'role_id'=>$role_id,
						'user_id'=>$user_id,
						'disabled'=>0,
					]);
	 			}
			}
			message_success("Record added successfully!");
			redirect($admin_route. '/' . $plugin_route . '/view/' . $user_id);
		}
	}

	if(!$csrf) {
		set_value('errors',$user->errors);
	}
		$user->errors['email'] = "Form expired!";
	
	set_value('errors',$user->errors);