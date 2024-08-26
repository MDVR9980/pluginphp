<?php

if(!empty($row)) {
	$postdata = $req->post();
	$filedata = $req->files();
	$postdata['id'] = $row->id;

	$csrf = csrf_verify($postdata);

	$files_ok = true;
	if(!empty($filedata)){

		$req->upload_folder = plugin_path('uploads');
		$postdata['image'] = $req->upload_files('image');
		$postdata['mega_image'] = $req->upload_files('mega_image');

		if(!empty($req->upload_errors))
			$files_ok = false;
	}

	if($csrf && $files_ok && $menu->validate_update($postdata)) {
		dd('here');
		if(user_can('edit_menu_page')) {
			dd('here2');
 			$image = new \Core\Image;
			unset($postdata['id']);

			if(empty($postdata['image']))
				unset($postdata['image']);

			if(empty($postdata['mega_image']))
				unset($postdata['mega_image']);
			
			if(!empty($postdata['remove_image']))
				$postdata['image'] = "";

			if(!empty($postdata['remove_mega_image']))
				$postdata['mega_image'] = "";
			
			$menu->update($row->id,$postdata);

			if((!empty($postdata['remove_image']) || !empty($postdata['image'])) && file_exists($row->image)) {
				unlink($image->get_thumbnail($row->image));
				unlink($row->image);
			}

			if((!empty($postdata['remove_mega_image']) || !empty($postdata['mega_image'])) && file_exists($row->mega_image)) {
				unlink($image->get_thumbnail($row->mega_image));
				unlink($row->mega_image);
			}
 			
			message_success("Record edited successfully!");
			redirect($admin_route.'/'.$plugin_route.'/view/'.$row->id);
		}
	}

	if(!$csrf)
		$menu->errors['email'] = "Form expired!";

	set_value('errors',array_merge($menu->errors,$req->upload_errors));
} else {
	message_fail("Record not found");
}