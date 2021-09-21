<?php

Flight::route('GET /books', function(){
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 10);
    $search = Flight::query('search');
    $order = Flight::query('order', "-id");

    Flight::json(Flight::bookService()->get_books($search, $offset, $limit, $order));
});


Flight::route('GET /books/@id', function($id){
    Flight::json(Flight::bookService()->get_by_id($id));
});


Flight::route('POST /books', function(){
    $user = Flight::get('user');
    $data = Flight::request()->data->getData();
    Flight::json(Flight::bookService()->add_book($user, $data));
});


Flight::route('PUT /books/@id', function($id){
    $user = Flight::get('user');
    $data = Flight::request()->data->getData();
    Flight::json(Flight::bookService()->update_book($user, $id, $data));
});

Flight::route('GET /mybooks', function(){
    $user_id = Flight::get('user')['id'];
    Flight::json(Flight::bookService()->get_by_user_id($user_id));
});

Flight::route('GET /books/my', function(){
    $user_id = Flight::get('user')['id'];
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 10);
    $search = Flight::query('search');
    $order = Flight::query('order', "-id");

    Flight::json(Flight::bookService()->get_books_by_user($user_id, $search, $offset, $limit, $order));
});

?>