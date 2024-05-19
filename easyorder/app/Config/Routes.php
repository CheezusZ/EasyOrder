<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');
$routes->get('/', 'OrderController::index');
$routes->get('/orders', 'OrderController::orders');
$routes->get('/orders/(:num)', 'OrderController::orderDetail/$1');
$routes->post('/orders/updateStatus/(:num)', 'OrderController::updateOrderStatus/$1');
$routes->get('/customer/order/(:num)', 'OrderController::customerOrderDetail/$1');
$routes->group('menuedit', function($routes) {
    $routes->get('/', 'OrderController::menuedit');
    $routes->match(['get', 'post'], 'addeditcategory', 'OrderController::addeditCategory');
    $routes->match(['get', 'post'], 'addeditcategory/(:num)', 'OrderController::addeditCategory/$1');
    $routes->post('attemptSaveCategory', 'OrderController::attemptSaveCategory');
    $routes->get('deleteCategory/(:num)', 'OrderController::deleteCategory/$1');
    $routes->match(['get', 'post'], 'addedititem', 'OrderController::addedititem');
    $routes->get('addeditItem/(:num)', 'OrderController::addeditItem/$1');
    $routes->post('attemptSaveItem', 'OrderController::attemptSaveItem');
    $routes->get('deleteItem/(:num)', 'OrderController::deleteItem/$1');
});
$routes->get('/qrcodes', 'OrderController::qrcodes');
$routes->post('/qrcodes/add', 'OrderController::addTable');
$routes->get('/qrcodes/delete/(:num)', 'OrderController::deleteTable/$1');
$routes->get('/placeorder/(:num)', 'OrderController::placeorder/$1');
$routes->post('/placeorder/(:num)/createOrder', 'OrderController::createOrder/$1');
$routes->match(['get', 'post'], 'auth', 'UserController::auth');
$routes->get('auth', 'UserController::auth');
$routes->get('logout', 'UserController::logout'); 
$routes->post('attemptAuth', 'UserController::attemptAuth');
$routes->get('/admin', 'UserController::admin');
$routes->get('/admin/edit/(:num)', 'UserController::editUser/$1');
$routes->post('/admin/update/(:num)', 'UserController::updateUser/$1');
$routes->get('/admin/delete/(:num)', 'UserController::deleteUser/$1');