<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->post('create', 'Home::create');

$routes->post('/update', 'Home::update');

$routes->delete('/delete/(:num)', 'Home::delete/$1');
