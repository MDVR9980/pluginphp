<?php

	$slider = new \Slider\Slider_image;
	$info['success'] = false;

	$postdata = $req->post();
	$filedata = $req->files();

	$files_ok = true;
	if(!empty($filedata)) {

		$req->upload_folder = plugin_path('uploads');
		$postdata['image'] = $req->upload_files('image');
		if(!empty($req->upload_errors))
			$files_ok = false;
	}
	
	$csrf = csrf_verify($postdata);
	if($csrf && $files_ok && $slider->validate_insert($postdata)) {
		if(user_can('add_slider_image')) {

			$row = $slider->first(['id'=>$postdata['id']]);

			if($row) {
				$slider->update($row->id, $postdata);
				$info['message'] = "Record updated successfully!";
			} else {
				$slider->insert($postdata);
				$info['message'] = "Record added successfully!";
			}
			$info['success'] = true;
			echo json_encode($info);
			die;
		}
	}

	if(!$csrf)
		$slider->errors['email'] = "Form expired!";
	
	$info['errors'] = $slider->errors;
	echo json_encode($info);
die;