<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->group('admin', function ($routes) {
	// Rutas del Módulo de Usuarios
	$routes->get('users/list', 'Users::list');
	$routes->post('users/store', 'Users::store');
	$routes->post('users/destroy', 'Users::destroy');
	$routes->post('users/updating', 'Users::updating');
	
	// Rutas del Módulo de Categorias
	$routes->get('/categories', 'Categories::index');
	$routes->get('categories/list', 'Categories::list');
	$routes->post('categories/store', 'Categories::store');
	$routes->post('categories/destroy', 'Categories::destroy');
	$routes->post('categories/updating', 'Categories::updating');
});

// Otras Rutas
$routes->get('/', 'Users::index');
$routes->get('/info', 'Home::codeigniter');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
