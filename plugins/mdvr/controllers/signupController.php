<?php

$user = new \mdvr\User;

if($user->validate_insert($req->post())) {
    $postdata = $req->post();
    $postdata['data-created'] = date('Y-m-d H:i:s');
    $postdata['password'] = password_hash($postdata['password'], PASSWORD_DEFAULT);
    $user->insert($postdata);
    message('Signup complite! Please login to continue ');
    redirect($vars['login_page']);
} else {
    set_value('errors', $user->errors);
}
