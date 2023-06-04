<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

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
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'MainController::index');


$routes->group('api', static function ($routes) {
    $routes->group('v1', static function ($routes) {
        // $routes->options('(:any)', 'APIController::login');
        $routes->post('login', 'APIController::login');
        $routes->get('link/(:segment)', 'APIController::getDawlyURL/$1');
        $routes->post('new', 'APIController::newDawly');
        $routes->post('register', 'APIController::register');
    });
    
    
    $routes->group('v2', ['filter' => 'jwt'], static function ($routes) {
        $routes->post('options', 'APIController::getDawlyOptions');
        $routes->post('users', 'APIController::users');
        $routes->post('urole', 'APIController::user_role');
        
        $routes->put('edituser', 'APIController::edit_user');
        
        $routes->post('isingroup', 'APIController::is_in_group');
        $routes->post('create', 'APIController::create');
        $routes->post('editlink', 'APIController::editlink');
    });

    $routes->group('v2', static function ($routes){
        $routes->options('create', 'APIController::create');
        $routes->options('options', 'APIController::getDawlyOptions');
        $routes->options('users', 'APIController::users');
        $routes->options('edituser', 'APIController::edit_user');
        $routes->options('editlink', 'APIController::editlink');
    });
});



/* ELFINDER */

$routes->post('fileconnector', 'FileExplorerController::connector');
$routes->get('fileconnector', 'FileExplorerController::connector');
$routes->post('filemanager', 'FileExplorerController::manager');
$routes->get('filemanager', 'FileExplorerController::manager');

$routes->get('fileget/(:any)', 'FileExplorerController::getFile');

// login
$routes->get('login', 'AuthController::index');
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');
$routes->get('register', 'AuthController::registerview');
$routes->post('register', 'AuthController::register');

// dashboard
$routes->get('dashboard', 'DashboardController::index');
$routes->get('createnew', 'DashboardController::createnew');
$routes->get('manage', 'DashboardController::manageLinks');
$routes->get('users', 'DashboardController::adminusers');
$routes->post('users', 'DashboardController::adminusers');
// $routes->post('users', 'DashboardController::users_posts');
$routes->get('folders', 'FileExplorerController::manager');

// shorten
$routes->post('short', 'LinksController::index');
$routes->post('shorten', 'LinksController::shorten');

// links
$routes->get('show_link', 'LinksController::show');
$routes->post('dashboard/updateLink', 'LinksController::updateLink');
$routes->post('delete', 'LinksController::deleteLink');


// http://daw.ly/XXXXXXX
$routes->post('destroy_session', 'MainController::destroy_session');
$routes->get('(:any)', 'LinksController::redirect/$1');

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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
