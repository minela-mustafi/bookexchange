<?php

Flight::route('GET /exchanges', function(){
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 10);
    $order = Flight::query('order', "-id");

    Flight::json(Flight::exchangeService()->get_all($offset, $limit, $order));
});


Flight::route('GET /exchanges/@id', function($id){
    Flight::json(Flight::exchangeService()->get_by_id($id));
});


Flight::route('POST /exchanges', function(){
    $user = Flight::get('user');
    $data = Flight::request()->data->getData();
    Flight::json(Flight::exchangeService()->add_exchange($user, $data));
});


Flight::route('PUT /exchanges/@id', function($id){
    $user = Flight::get('user');
    $data = Flight::request()->data->getData();
    Flight::json(Flight::exchangeService()->update_exchange($user, $id, $data));
});


Flight::route('GET /exchanges/book/@book_id', function($book_id){
    Flight::json(Flight::exchangeService()->get_by_book_id($book_id));
});


Flight::route('GET /exch-borrowed', function(){
    $borrower_id = Flight::get('user')['id'];
    Flight::json(Flight::exchangeService()->get_borrowed($borrower_id));
});


Flight::route('GET /exch-lent', function(){
    $lender_id = Flight::get('user')['id'];
    Flight::json(Flight::exchangeService()->get_lent($lender_id));
});


Flight::route('GET /exch-returned', function(){
    $lender_id = Flight::get('user')['id'];
    Flight::json(Flight::exchangeService()->get_returned($lender_id));
});


Flight::route('GET /exch-not-returned', function(){
    $lender_id = Flight::get('user')['id'];
    Flight::json(Flight::exchangeService()->get_not_returned($lender_id));
});


Flight::route('PUT /exch-return/@id', function($id){
    $lender = Flight::get('user');
    $data = Flight::request()->data->getData();
    Flight::json(Flight::exchangeService()->return_book($lender, $id, $data['returndate']));
});

?>