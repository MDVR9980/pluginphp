<?php


	$postdata = $req->post();

	$csrf = csrf_verify($postdata);
	if($csrf && $user_role->validate_insert($postdata)) {
		if(user_can('add_role')) {
			
			$user_role->insert($postdata);

			message_success("Record added successfully!");
			redirect($admin_route.'/'.$plugin_route.'/view/'.$user_role->insert_id);
		}
	}

	if(!$csrf)
		$user_role->errors['email'] = "Form expired!";
	
	set_value('errors',$user_role->errors);