<?php

$route->addRoute('POST', '/all_post', 	'Products::allpost');
$route->addRoute('POST', '/user_login',	'Products::login');
$route->addRoute('POST', '/song_list', 	'Products::get_all_songs');
$route->addRoute('POST', '/send_post', 	'Products::do_save_post');
$route->addRoute('POST', '/like_post', 	'Products::like_post');
$route->addRoute('POST', '/unlike_post', 'Products::unlike_post');
$route->addRoute('POST', '/my_notification', 'Products::my_notification');
$route->addRoute('POST', '/current_song', 'Products::current_song');
$route->addRoute('POST', '/update_token', 'Products::update_token');
$route->addRoute('POST', '/play_song', 'Products::play_song');
$route->addRoute('POST', '/user_information', 'Products::get_user_information');
$route->addRoute('POST', '/my_information', 'Products::get_my_information');
$route->addRoute('POST', '/follow_user', 'Products::follow_user');
$route->addRoute('POST', '/unfollow_user', 'Products::unfollow_user');
$route->addRoute('POST', '/user_match', 'Products::get_user_song_match');
$route->addRoute('POST', '/accept_match', 'Products::accept_match');
$route->addRoute('POST', '/decline_match', 'Products::decline_match');
$route->addRoute('POST', '/undecline_match', 'Products::undecline_match');
$route->addRoute('POST', '/delete_match', 'Products::delete_match');
$route->addRoute('POST', '/connect_list', 'Products::connect_list');
$route->addRoute('POST', '/list_preview_song', 'Products::list_preview_song');
$route->addRoute('POST', '/connect_host', 'Products::connect_host');
$route->addRoute('POST', '/chat_list', 'Products::chat_list');
$route->addRoute('POST', '/first_update', 'Products::first_update');
$route->addRoute('POST', '/user_post', 'Products::user_post');
$route->addRoute('POST', '/top_played', 'Products::top_played');


