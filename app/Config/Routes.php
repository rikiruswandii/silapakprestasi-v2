<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

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
$routes->set404Override('App\Controllers\Home::override');
$routes->setAutoRoute(false);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('contact-us', 'Home::contact');
$routes->get('about', 'Home::about');
//convert kml
// Routes for maps
$routes->get('maps', 'Maps::index');
// Search KMZ

// Routes for investments
$routes->group('investments', static function (RouteCollection $routes) {
    $routes->get('/', 'Investments::index');
    $routes->get('(:segment)', 'Investments::sector/$1');
    $routes->get('(:segment)/(:segment)', 'Investments::subsector/$1/$2');
});
$routes->get('investment/(:segment)', 'Investments::read/$1');

// Routes for profiles
$routes->get('profiles', 'Profiles::index');
$routes->get('profile/(:segment)', 'Profiles::read/$1');

// Routes for innovations
$routes->group('innovations', static function (RouteCollection $routes) {
    $routes->get('/', 'Innovations::index');
    $routes->get('(:segment)', 'Innovations::list/$1');
});
$routes->get('innovation/(:segment)', 'Innovations::read/$1');

// Routes for regulations
$routes->get('regulation/(:segment)/(:segment)', 'Regulations::list/$1/$2');

// Routes for search all products
$routes->get('search', 'Search::index');

// Routes for news & category
$routes->group('news', static function (RouteCollection $routes) {
    $routes->get('/', 'News::index');
    $routes->get('(:segment)', 'News::read/$1');
});
$routes->get('category/(:segment)', 'News::category/$1');

// Routes for API
$routes->group('api', static function (RouteCollection $routes) {
    $routes->get('/', 'Api::index');
    $routes->get('kmz', 'Api::kmz');
    $routes->get('districts', 'Api::districts');
    $routes->post('contact-us', 'Api::contact');
    $routes->post('subscribe/(:hash)', 'Api::subscribe/$1');
});

// Routes for authentication page
$routes->group('auth', static function (RouteCollection $routes) {
    $routes->get('/', static function () {
        return redirect('auth/login');
    });

    $routes->get('login', 'Auth::index');
    $routes->post('check', 'Auth::check');

    $routes->get('logout', 'Auth::kill', ['filter' => 'auth']);
});

// Manipulating authentication routes
$routes->get('login', static function () {
    return redirect('auth/login');
});
$routes->get('logout', static function () {
    return redirect('auth/logout');
});

// Routes for app panel
$routes->group('panel', ['filter' => 'auth'], static function (RouteCollection $routes) {
    // Overview page
    $routes->get('/', static function () {
        return redirect('login');
    });
    $routes->get('overview', 'App\Home::index');

    // Categories
    $routes->group('categories', static function (RouteCollection $routes) {
        $routes->get('/', 'App\Categories::index');
        $routes->get('datatable', 'App\Categories::datatable');

        $routes->post('insert', 'App\Categories::insert');
        $routes->post('update/(:num)', 'App\Categories::update/$1');
        $routes->post('delete/(:num)', 'App\Categories::delete/$1');
    });

    // News
    $routes->group('news', static function (RouteCollection $routes) {
        $routes->get('/', 'App\News::index');
        $routes->get('datatable', 'App\News::datatable');
        $routes->get('add', 'App\News::add');
        $routes->get('edit/(:hash)', 'App\News::edit/$1');

        $routes->post('insert', 'App\News::insert');
        $routes->post('update/(:num)', 'App\News::update/$1');
        $routes->post('delete/(:num)', 'App\News::delete/$1');
    });

    // $routes->group('kmz', static function (RouteCollection $routes) {
    //     $routes->get('/', 'App\Kmz::index');
    //     $routes->get('datatable', 'App\Kmz::datatable');

    //     $routes->post('upload', 'App\Kmz::upload');
    //     $routes->post('update/(:num)', 'App\Kmz::update/$1');
    //     $routes->post('delete/(:num)', 'App\Kmz::delete/$1');
    // });
    $routes->group('geojson', static function (RouteCollection $routes) {
        $routes->get('/', 'App\Geojson::index');
        $routes->get('datatable', 'App\Geojson::datatable');

        $routes->post('upload', 'App\Geojson::upload');
        $routes->post('update/(:num)', 'App\Geojson::update/$1');
        $routes->post('delete/(:num)', 'App\Geojson::delete/$1');
    });

    // Investments
    $routes->group('investments', static function (RouteCollection $routes) {
        $routes->get('/', 'App\Investments::index');
        $routes->get('datatable', 'App\Investments::datatable');
        $routes->get('add', 'App\Investments::add');
        $routes->get('edit/(:hash)', 'App\Investments::edit/$1');

        $routes->get('sectors', 'App\Investments::sectors');

        $routes->post('insert', 'App\Investments::insert');
        $routes->post('update/(:num)', 'App\Investments::update/$1');
        $routes->post('delete/(:num)', 'App\Investments::delete/$1');
    });

    // Profiles
    $routes->group('profiles', static function (RouteCollection $routes) {
        $routes->get('/', 'App\Profiles::index');
        $routes->get('datatable', 'App\Profiles::datatable');
        $routes->get('add', 'App\Profiles::add');
        $routes->get('edit/(:hash)', 'App\Profiles::edit/$1');

        $routes->post('insert', 'App\Profiles::insert');
        $routes->post('update/(:num)', 'App\Profiles::update/$1');
        $routes->post('delete/(:num)', 'App\Profiles::delete/$1');
    });

    // Innovations
    $routes->group('innovations', static function (RouteCollection $routes) {
        $routes->get('/', 'App\Innovations::index');
        $routes->get('datatable', 'App\Innovations::datatable');
        $routes->get('add', 'App\Innovations::add');
        $routes->get('edit/(:hash)', 'App\Innovations::edit/$1');

        $routes->post('insert', 'App\Innovations::insert');
        $routes->post('update/(:num)', 'App\Innovations::update/$1');
        $routes->post('delete/(:num)', 'App\Innovations::delete/$1');
    });

    // Regulations
    $routes->group('regulations', static function (RouteCollection $routes) {
        $routes->get('/', 'App\Regulations::index');
        $routes->get('datatable', 'App\Regulations::datatable');

        $routes->post('upload', 'App\Regulations::upload');
        $routes->post('update/(:num)', 'App\Regulations::update/$1');
        $routes->post('delete/(:num)', 'App\Regulations::delete/$1');
    });

    // Subscriptions
    $routes->group('subscriptions', static function (RouteCollection $routes) {
        $routes->get('/', 'App\Subscriptions::index');
        $routes->get('datatable', 'App\Subscriptions::datatable');

        $routes->post('delete/(:num)', 'App\Subscriptions::delete/$2');
    });

    // Contacts
    $routes->group('contacts', static function (RouteCollection $routes) {
        $routes->get('/', 'App\Contacts::index');
        $routes->get('datatable', 'App\Contacts::datatable');
    });

    // About
    $routes->group('about', static function (RouteCollection $routes) {
        $routes->get('/', 'App\About::index');
        $routes->post('save', 'App\About::save');
    });

    // Profile page
    $routes->group('profile', static function (RouteCollection $routes) {
        $routes->get('/', 'App\Profile::index');

        $routes->post('save', 'App\Profile::save');
        $routes->post('password', 'App\Profile::password');
    });

    // Users management page
    $routes->group('users', static function (RouteCollection $routes) {
        $routes->get('/', 'App\Users::index');
        $routes->get('datatable', 'App\Users::datatable');

        $routes->post('insert', 'App\Users::insert');
        $routes->post('update/(:num)', 'App\Users::update/$1');
        $routes->post('delete/(:num)', 'App\Users::delete/$1');
    });
});

/**
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
