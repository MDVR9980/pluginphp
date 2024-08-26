<?php

if(!empty($row)) {
	$postdata = $req->post();

	$csrf = csrf_verify($postdata);
	if($csrf) {
 		if(user_can('delete_menu_page')) {
			$image = new \Core\Image;
	 		$user->delete($row->id);
	 		
	 		if(file_exists($row->image))
				unlink($row->image);
			
			if(file_exists($row->mega_image))
				unlink($row->image);

			if(file_exists($image->get_thumbnail($row->image)))
				unlink($image->get_thumbnail($row->image));
			
			if(file_exists($image->get_thumbnail($row->mega_image)))
				unlink($image->get_thumbnail($row->image));
			
			message_success("Record deleted successfully!");
			redirect($admin_route.'/'.$plugin_route);
		}
	}

	$user->errors['email'] = "Form expired!";

	set_value('errors',$user->errors);
} else {
	message_fail("Record not found");
}
