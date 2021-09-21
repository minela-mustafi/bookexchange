<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(__FILE__).'/services/UserService.class.php';
require_once dirname(__FILE__).'/services/ProfileService.class.php';
require_once dirname(__FILE__).'/services/BookService.class.php';
require_once dirname(__FILE__).'/services/RequestService.class.php';
require_once dirname(__FILE__).'/services/ExchangeService.class.php';

Flight::set('flight.log_errors', TRUE);

// Error handling for API
Flight::map('error', function(Exception $ex){
    Flight::json(["message" => $ex->getMessage()], $ex->getCode() ? $ex->getCode() : 500);
});


// Utility function for reading query parameters from URL
Flight::map('query', function($name, $default_value = NULL){
    $request = Flight::request();
    $query_param = @$request->query->getData()[$name];
    $query_param = $query_param ? $query_param : $default_value;
    return $query_param;
});

// Utility function for getting header parameters
Flight::map('header', function($name){
    $headers = getallheaders();
    return @$headers[$name];
});

// Utility function for generating JWT token
Flight::map('jwt', function($user){
    $jwt = \Firebase\JWT\JWT::encode(["exp" => (time() + Config::JWT_TOKEN_TIME), "id" => $user["id"], "r" => $user["role"]], Config::JWT_SECRET);
    return ["token" => $jwt];
});


// Register Business logic layer services
Flight::register('userService', 'UserService');
Flight::register('profileService', 'ProfileService');
Flight::register('bookService', 'BookService');
Flight::register('requestService', 'RequestService');
Flight::register('exchangeService', 'ExchangeService');

// Include all routes
//require_once dirname(__FILE__)."/routes/middleware.php";
require_once dirname(__FILE__)."/routes/middleware.php";
require_once dirname(__FILE__)."/routes/users.php";
require_once dirname(__FILE__)."/routes/profiles.php";
require_once dirname(__FILE__)."/routes/books.php";
require_once dirname(__FILE__)."/routes/requests.php";
require_once dirname(__FILE__)."/routes/exchanges.php";


Flight::start();

?>