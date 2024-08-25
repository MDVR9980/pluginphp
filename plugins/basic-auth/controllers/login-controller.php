<?php

	$user = new \BasicAuth\User;

	if(csrf_verify($req->post())) {
		$postdata = $req->post();
		$row = $user->first(['email'=>$postdata['email']]);
		
		if($row) {
			if(password_verify($postdata['password'], $row->password)) {
				$ses->auth($row);
				redirect('home');
			}
		}
		message_fail('Wrong email or password');
	} else {
		message_fail('Form expired! Please refresh');
	}