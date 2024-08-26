<?php

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


    if($csrf && $files_ok && $user->validate_update($postdata)) {

        if(user_can('edit_user')) {
        
            if(isset($postdata['password']) && empty($postdata['password'])) {
                unset($postdata['password']);
            } else {
                $postdata['password'] = password_hash($postdata['password'], PASSWORD_DEFAULT);
            }
                
            $postdata['date_updated'] = date('Y-m-d H:i:s');
            $user->update($row->id, $postdata);
    
            if(!empty($postdata['image']) && file_exists($row->image)) 
                unlink($row->image);
    
            message_success('Record edited successfully!');
            redirect($admin_route . '/' . $plugin_route . '/view' . $row->id);
        } 
    }

    if(!$csrf) {
        $user->errors['email'] = 'Form expierd!';
        set_value('errors', $user->errors);
    }
    set_value('errors', array_merge($user->errors, $req->upload_errors));
} else {
    message_fail('Record not found');
}

