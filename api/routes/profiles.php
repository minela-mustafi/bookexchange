<?php

Flight::route('GET /profiles', function(){
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 10);
    $search = Flight::query('search');
    $order = Flight::query('order', "-id");

    Flight::json(Flight::profileService()->get_profiles($search, $offset, $limit, $order));
});


Flight::route('GET /profiles/@id', function($id){
    Flight::json(Flight::profileService()->get_by_id($id));
});


Flight::route('POST /profiles', function(){
    $user = Flight::get('user');
    $data = Flight::request()->data->getData();
    Flight::json(Flight::profileService()->add_profile($user, $data));
});


Flight::route('PUT /profiles/@id', function($id){
    $user = Flight::get('user');
    $data = Flight::request()->data->getData();
    Flight::json(Flight::profileService()->update_profile($user, $id, $data));
});


?>
