<?php

	$info = [];
	$info['success'] = false;
	$info['message'] = "";
	$info['errors'] = [];

	$postdata = $req->post();
	$filedata = $req->files();

	$files_ok = true;
	if(!empty($filedata)) {
		$postdata['image'] = $req->upload_files('image');
		if(!empty($req->upload_errors))
			$files_ok = false;
	}
	
	$csrf = csrf_verify($postdata);
	if($csrf && $files_ok && $page->validate_insert($postdata)) {
		if(user_can('add_page')) {
			$content = new \BasicPages\Content;
			$postdata['content'] = $content->extract_images($postdata['content']);
			
			$postdata['user_id'] = $ses->user('id');
			$postdata['date_created'] = date("Y-m-d H:i:s");
			$postdata['slug'] = $page->str_to_url($postdata['title']);
			
			$num = 0;
			while ($num < 20 && $page->first(['slug'=>$postdata['slug']])) {
				$postdata['slug'] .= rand(0,9);
				$num++;
			}

			$page->insert($postdata);
			$page_id = $page->insert_id;
			
 			//save categories
			$cm = new \BasicPages\Categories_map;
 			$cm->save_new($page_id,$postdata['category']);

 			$info['success'] = true;
			$info['message'] = "Record added successfully!";

		}
	}

	if(!$csrf)
		$page->errors['title'] = "Form expired!";
	
	$info['errors'] = $page->errors;

	echo json_encode($info);
die;