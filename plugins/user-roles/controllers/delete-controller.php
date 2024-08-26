<?php

if(!empty($row)) {
	$postdata = $req->post();

	$csrf = csrf_verify($postdata);
	if($csrf) {
 		if(user_can('delete_role')) {
	 		$user_role->delete($row->id);
 
			message_success("Record deleted successfully!");
			redirect($admin_route.'/'.$plugin_route);
		}
	}
	$user_role->errors['role'] = "Form expired!";
	set_value('errors',$user_role->errors);
} else {
	message_fail("Record not found");
}