<?php

if(!empty($row)) {
	$postdata = $req->post();

	$csrf = csrf_verify($postdata);
	if($csrf) {
 		if(user_can('delete_post')) {
	 		$post->delete($row->id);
	 		
	 		if(file_exists($row->image))
				unlink($row->image);

			message_success("Record deleted successfully!");
			redirect($admin_route.'/'.$plugin_route);
		}
	}

	$post->errors['email'] = "Form expired!";

	set_value('errors',$post->errors);
} else {
	message_fail("Record not found");
}
