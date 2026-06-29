<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->post('api/login', 'Api\Auth::login');
$routes->setAutoRoute(False);
$routes->get('/', 'Home::index');
$routes->get('admin', 'Artikel::admin_index');
$routes->get('/about', 'Page::about');
$routes->get('/contact', 'Page::contact');
$routes->get('/faqs', 'Page::faqs');
$routes->get('artikel', 'Artikel::index');
$routes->get('/artikel/(:any)', 'Artikel::view/$1');

$routes->get('user/login', 'User::login');
$routes->post('user/login', 'User::login');

$routes->get('/login', 'User::login');
$routes->post('/login', 'User::login');
$routes->resource('post');

$routes->group('admin', function($routes) {
    $routes->get('artikel', 'Artikel::admin_index');
    $routes->add('artikel/add', 'Artikel::add');
    $routes->add('artikel/edit/(:any)', 'Artikel::edit/$1');
    $routes->get('artikel/delete/(:any)', 'Artikel::delete/$1');
    
    $routes->get('ajax', 'AjaxController::index');
    $routes->get('ajax/getData', 'AjaxController::getData');
    $routes->get('ajax/getOne/(:num)', 'AjaxController::getOne/$1');
    $routes->post('ajax/save', 'AjaxController::save');
    $routes->post('ajax/update', 'AjaxController::update');
    $routes->post('ajax/delete/(:num)', 'AjaxController::delete/$1');
});


