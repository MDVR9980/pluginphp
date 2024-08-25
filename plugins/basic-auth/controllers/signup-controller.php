<?php

$user = new \BasicAuth\User;

$csrf = csrf_verify($req->post());
$isValid = $user->validate_insert($req->post());

if($csrf && $isValid) {
    $postdata = $req->post();
    $postdata['data_created'] = date('Y-m-d H:i:s');
    $postdata['password'] = password_hash($postdata['password'], PASSWORD_DEFAULT);
    $user->insert($postdata);
    message_success('Signup complite! Please login to continue ');
    redirect($vars['login_page']);
} else {
    if(!$csrf)
        $user->errors['email'] = 'Form expired! Please refresh';

    set_value('errors', $user->errors);
}