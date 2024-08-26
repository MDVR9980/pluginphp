<?php

if(!empty($row)) {
	$postdata = $req->post();

	$csrf = csrf_verify($postdata);
	if($csrf) {
 		if(user_can('delete_category')) {
	 		$category->delete($row->id);
			message_success("Record deleted successfully!");
			redirect($admin_route.'/'.$plugin_route);
		}
	}
	$category->errors['email'] = "Form expired!";

	set_value('errors',$category->errors);
} else {
	message_fail("Record not found");
}
