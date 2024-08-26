<?php

if(!empty($row)) {
	$postdata = $req->post();
	$filedata = $req->files();
	$postdata['id'] = $row->id;

	$csrf = csrf_verify($postdata);

	$files_ok = true;
	if(!empty($filedata)) {
		$postdata['image'] = $req->upload_files('image');
		if(!empty($req->upload_errors))
			$files_ok = false;
	}

	if($csrf && $files_ok && $user->validate_update($postdata)) {
		if(user_can('edit_user')) {
			if(isset($postdata['password']) && empty($postdata['password'])){
				unset($postdata['password']);
			} else {
				$postdata['password'] = password_hash($postdata['password'], PASSWORD_DEFAULT);
			}

			$postdata['date_updated'] = date("Y-m-d H:i:s");
			unset($postdata['id']);

			if(empty($postdata['image']))
				unset($postdata['image']);

			$user->update($row->id,$postdata);

			if(!empty($postdata['image']) && file_exists($row->image))
				unlink($row->image);

			$user_id = $row->id;

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

 					$result = $user_roles_map->first(['role_id'=>$role_id,'user_id'=>$user_id]);
 					if($result) {
 						$user_roles_map->update($result->id,['disabled'=>0]);
 					} else {
 						$user_roles_map->insert([
 							'role_id'=>$role_id,
 							'user_id'=>$user_id,
 							'disabled'=>0,
 						]);
 					}
	 			}
			}
			message_success("Record edited successfully!");
			redirect($admin_route.'/'.$plugin_route.'/view/'.$row->id);
		}
	}

	if(!$csrf)
		$user->errors['email'] = "Form expired!";

	set_value('errors',array_merge($user->errors,$req->upload_errors));
} else {
	message_fail("Record not found");
}