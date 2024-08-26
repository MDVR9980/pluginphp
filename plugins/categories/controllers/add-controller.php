<?php

	$postdata = $req->post();

	$csrf = csrf_verify($postdata);
	if($csrf && $category->validate_insert($postdata)) {
		if(user_can('add_category')) {
			
			if(empty($postdata['slug'])) {
				$postdata['slug'] = $category->str_to_url($postdata['category']);
			}

			$num = 0;
			while ($num < 10 && $category->first(['slug'=>$postdata['slug']])) {
				$postdata['slug'] = $postdata['slug'] . rand(0,99);
				$num++;
			}
			
			$category->insert($postdata);
 
			message_success("Record added successfully!");
			redirect($admin_route.'/'.$plugin_route.'/view/'.$category->insert_id);
		}
	}

	if(!$csrf)
		$category->errors['email'] = "Form expired!";
	
	set_value('errors',$category->errors);