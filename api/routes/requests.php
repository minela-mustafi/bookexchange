<?php

Flight::route('GET /requests', function(){
    $offset = Flight::query('offset', 0);
    $limit = Flight::query('limit', 10);
    $order = Flight::query('order', "-id");

    Flight::json(Flight::requestService()->get_all($offset, $limit, $order));
});


Flight::route('GET /requests/@id', function($id){
    Flight::json(Flight::requestService()->get_by_id($id));
});


Flight::route('POST /requests', function(){
    $user = Flight::get('user');
    $data = Flight::request()->data->getData();
    Flight::json(Flight::requestService()->add_request($user, $data));
});


Flight::route('PUT /requests/@id', function($id){
    $user = Flight::get('user');
    $data = Flight::request()->data->getData();
    Flight::json(Flight::requestService()->update_request($user, $id, $data));
});


Flight::route('GET /requests/book/@book_id', function($book_id){
    Flight::json(Flight::requestService()->get_by_book_id($book_id));
});


Flight::route('GET /req-borrow', function(){
    $borrower_id = Flight::get('user')['id'];
    Flight::json(Flight::requestService()->get_borrowed($borrower_id));
});


Flight::route('GET /req-lend', function(){
    $lender_id = Flight::get('user')['id'];
    Flight::json(Flight::requestService()->get_lent($lender_id));
});


Flight::route('GET /req-open', function(){
    $lender_id = Flight::get('user')['id'];
    Flight::json(Flight::requestService()->get_open_requests($lender_id));
});


Flight::route('PUT /req-accept/@id', function($id){
    $lender = Flight::get('user');
    Flight::json(Flight::requestService()->accept_request($lender, $id));
});


Flight::route('PUT /req-deny/@id', function($id){
    $lender = Flight::get('user');
    Flight::json(Flight::requestService()->deny_request($lender, $id));
});


Flight::route('PUT /req-close/@id', function($id){
    $borrower = Flight::get('user');
    Flight::json(Flight::requestService()->close_request($borrower, $id));
});

?>