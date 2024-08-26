<?php

if(!empty($row)) {
	$postdata = $req->post();
	$postdata['id'] = $row->id;

	$csrf = csrf_verify($postdata);

	if($csrf && $category->validate_update($postdata)) {
		if(user_can('edit_category')) {

			unset($postdata['id']);
			$category->update($row->id,$postdata);

			message_success("Record edited successfully!");
			redirect($admin_route.'/'.$plugin_route.'/view/'.$row->id);
		}
	}

	if(!$csrf)
		$category->errors['email'] = "Form expired!";

	set_value('errors',array_merge($category->errors,$req->upload_errors));
} else {
	message_fail("Record not found");
}
