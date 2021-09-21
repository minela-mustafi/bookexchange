<?php

Flight::route('POST /register', function(){
    $data = Flight::request()->data->getData();
    Flight::userService()->register($data);
    Flight::json(["message" => "New user registrated."]);
});


Flight::route('GET /confirm/@token', function($token){
    Flight::json(Flight::jwt(Flight::userService()->confirm($token)));
});


Flight::route('POST /login', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::jwt(Flight::userService()->login($data)));
});



Flight::route('GET /admin/users', function($offset = 0, $limit = 10, $order = "-id"){
    Flight::json(Flight::userService()->get_all($offset, $limit, $order));
});


Flight::route('GET /admin/users/@id', function($id){
    Flight::json(Flight::userService()->get_by_id($id));
});


Flight::route('PUT /admin/users/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::userService()->update_user($id, $data));
});

?>
