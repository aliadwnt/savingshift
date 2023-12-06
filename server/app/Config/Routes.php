<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->match(['post', 'options'], 'register', 'UserController::register');
$routes->get('users', 'UserController::index');
$routes->match(['post', 'options'], 'login', 'UserController::login');
$routes->match(['put', 'options'], 'update-user/(:any)', 'UserController::update/$1');
$routes->match(['delete', 'options'], 'delete-user/(:any)', 'UserController::delete/$1');