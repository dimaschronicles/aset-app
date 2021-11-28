<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
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

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Auth::index');
$routes->get('/auth', 'Auth::index');
$routes->get('/auth/logout', 'Auth::logout');
$routes->get('/home', 'Home::index', ['filter' => 'isLoggedIn']);

// user
$routes->get('/user', 'User::index');
$routes->get('/user/add', 'User::create');
$routes->post('/user', 'User::save');
$routes->get('/user/edit/(:any)', 'User::edit/$1');
$routes->put('/user/(:any)', 'User::update/$1');
$routes->delete('/user/(:num)', 'User::delete/$1');
$routes->get('/user/detail/(:segment)', 'User::detail/$1');

// gedung
$routes->get('/gedung', 'Gedung::index');
$routes->get('/gedung/add', 'Gedung::create');
$routes->post('/gedung', 'Gedung::save');
$routes->get('/gedung/edit/(:any)', 'Gedung::edit/$1');
$routes->put('/gedung/(:any)', 'Gedung::update/$1');
$routes->delete('/gedung/(:num)', 'Gedung::delete/$1');

// ruangan
$routes->get('/ruang', 'Ruang::index');
$routes->get('/ruang/add', 'Ruang::create');
$routes->post('/ruang', 'Ruang::save');
$routes->get('/ruang/edit/(:any)', 'Ruang::edit/$1');
$routes->put('/ruang/(:any)', 'Ruang::update/$1');
$routes->delete('/ruang/(:num)', 'Ruang::delete/$1');

// aset
$routes->get('/aset', 'Aset::index');
$routes->get('/aset/add', 'Aset::create');
$routes->post('/aset', 'Aset::save');
$routes->get('/aset/edit/(:any)', 'Aset::edit/$1');
$routes->put('/aset/(:any)', 'Aset::update/$1');
$routes->delete('/aset/(:num)', 'Aset::delete/$1');
$routes->get('/aset/restore(:segment)', 'Aset::restore/$1');
$routes->delete('/aset/destroy/(:any)', 'Aset::destroy/$1');

// laporan
$routes->get('/laporan', 'Report::index');
$routes->get('/laporan/invoice', 'Report::invoice');
$routes->get('/laporan/testpdf', 'Report::testpdf');

// profil
$routes->get('/profile', 'Profile::index');
$routes->post('/profile', 'Profile::editprofile');
$routes->get('/profile/changepassword', 'Profile::changepassword');
$routes->post('/profile/change', 'Profile::change');

/**
 * REST API
 */
$routes->resource('apiuser');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
