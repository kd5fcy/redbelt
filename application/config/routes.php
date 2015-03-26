<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "books";
$route['404_override'] = '';
$route['books/book/(:num)'] = '/books/book/$1';
$route['books/delete/(:num)'] = '/books/delete/$1';
$route['books/users/(:num)'] = '/books/users/$1';

//end of routes.php