<?php

	$info = [];
	$info['success'] = false;
	$info['message'] = "";
	$info['errors'] = [];

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

	if($csrf && $files_ok && $page->validate_update($postdata)) {
		if(user_can('edit_page')) {

			$content = new \BasicPages\Content;
			$postdata['content'] = $content->extract_images($postdata['content']);
			$postdata['content'] = $content->remove_root($postdata['content']);
			$content->delete_unused_images($row->content, $postdata['content']);

			$postdata['date_updated'] = date("Y-m-d H:i:s");
			unset($postdata['id']);

			if(empty($postdata['image']))
				unset($postdata['image']);

			$page->update($row->id,$postdata);

			if(!empty($postdata['image']) && file_exists($row->image))
				unlink($row->image);

			$page_id = $row->id;
			
 			//save categories
			$cm = new \BasicPages\Categories_map;
 			$cm->disable_all($page_id);
 			$cm->save_new($page_id,$postdata['category']);

			$info['success'] = true;
			$info['message'] = "Record edited successfully!";
		}
	}

	if(!$csrf)
		$page->errors['email'] = "Form expired!";

	 $info['errors'] = array_merge($page->errors,$req->upload_errors);
} else {
	$info['message'] = "Record not found";
}

echo json_encode($info);
die;