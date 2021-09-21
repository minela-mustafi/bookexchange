<?php

// Middleware for ensuring only loggedin users can have access
Flight::route('*', function(){
    if(str_starts_with(Flight::request()->url, '/register')
        || str_starts_with(Flight::request()->url, '/confirm/')
        || str_starts_with(Flight::request()->url, '/login'))
        return TRUE;

    try{
        $user = (array)\Firebase\JWT\JWT::decode(Flight::header("Authentication"), Config::JWT_SECRET, ["HS256"]);
        Flight::set('user', $user);
        return TRUE;
    }
    catch(\Exception $e){
        Flight::json(["message" => $e->getMessage()], 401);
        die;
    }
});


// Middleware for admin users
Flight::route('/admin/*', function(){
    try{
        $user = (array)\Firebase\JWT\JWT::decode(Flight::header("Authentication"), Config::JWT_SECRET, ["HS256"]);
        if($user['r'] != "admin"){
            throw new Exception("Admin access required.", 403);
        }
        Flight::set('user', $user);
        return TRUE;
    }
    catch(\Exception $e){
        Flight::json(["message" => $e->getMessage()], 401);
        die;
    }
});

?>