<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');

$routes->group('/', ['filter' => 'isGuest'], static function ($routes) {

    $routes->get("", "HomeController::index");

    $routes->get('/login', 'Guest\LoginController::index');

    $routes->post('login', 'Guest\LoginController::login');

});

$routes->group('/', ['filter' => 'isUser'], static function ($routes) {
    $routes->get('/logout', 'User\LogoutController::index');

});

$routes->group('dashboard', ['filter' => 'isUser'], static function ($routes) {
    $routes->get('', 'User\DashboardController::index',['as' => 'dashboard', 'bodyClass' => 'dashboard']);
    $routes->post('summary', 'User\DashboardController::summary',['as' => 'dashboard.summary']);
    $routes->post('stock', 'User\DashboardController::stock',['as' => 'dashboard.stock']);
 
});

$routes->group('roles', ['filter' => ['isUser', 'isAdmin']], static function ($routes) {
    $routes->get('', 'RolesController::index', ['as' => 'roles.index', 'bodyClass' => 'roles-list']);
    $routes->delete('(:num)', 'RolesController::delete/$1', ['as' => 'roles.delete']);
    $routes->post('list', 'RolesController::list', ['as' => 'roles.list']);
    $routes->post('', 'RolesController::save', ['as' => 'roles.save']);
});

$routes->group('users', ['filter' => ['isUser', 'isAdmin']], static function ($routes) {
    $routes->get('', 'UsersController::index', ['as' => 'users.index', 'bodyClass' => 'users-list']);
    $routes->delete('(:num)', 'UsersController::delete/$1', ['as' => 'users.delete']);
    $routes->post('list', 'UsersController::list', ['as' => 'users.list']);
    $routes->post('', 'UsersController::save', ['as' => 'users.save']);
});

$routes->group('unit-of-measures', ['filter' => ['isUser', 'isAdmin']], static function ($routes) {
    $routes->get('', 'UnitOfMeasuresController::index', ['as' => 'uom.index', 'bodyClass' => 'unit-of-measures-list']);
    $routes->delete('(:num)', 'UnitOfMeasuresController::delete/$1', ['as' => 'uom.delete']);
    $routes->post('list', 'UnitOfMeasuresController::list', ['as' => 'uom.list']);
    $routes->post('', 'UnitOfMeasuresController::save', ['as' => 'uom.save']);
});

$routes->group('categories', ['filter' => ['isUser', 'isAdmin']], static function ($routes) {
    $routes->get('', 'CategoryController::index', ['as' => 'categories.index', 'bodyClass' => 'categories-list']);
    $routes->post('select2', 'CategoryController::select2', ['as' => 'categories.select2']);
    $routes->delete('(:num)', 'CategoryController::delete/$1', ['as' => 'categories.delete']);
    $routes->post('list', 'CategoryController::list', ['as' => 'categories.list']);
    $routes->post('', 'CategoryController::save', ['as' => 'categories.save']);
});

$routes->group('products', ['filter' => ['isUser', 'isAdmin']], static function ($routes) {
    $routes->get('', 'ProductsController::index', ['as' => 'products.index', 'bodyClass' => 'products-list']);
    $routes->delete('(:num)', 'ProductsController::delete/$1', ['as' => 'products.delete']);
    $routes->post('list', 'ProductsController::list', ['as' => 'products.list']);
    $routes->post('', 'ProductsController::save', ['as' => 'products.save']);
    $routes->post('select2', 'ProductsController::select2', ['as' => 'products.select2']);

});

$routes->group('outlets', ['filter' => ['isUser', 'isAdmin']], static function ($routes) {
    $routes->get('', 'OutletsController::index', ['as' => 'outlets.index', 'bodyClass' => 'outlets-list']);
    $routes->delete('(:num)', 'OutletsController::delete/$1', ['as' => 'outlets.delete']);
    $routes->post('list', 'OutletsController::list', ['as' => 'outlets.list']);
    $routes->post('', 'OutletsController::save', ['as' => 'outlets.save']);
});

$routes->group('vendors', ['filter' => ['isUser', 'isAdmin']], static function ($routes) {
    $routes->get('', 'VendorsController::index', ['as' => 'vendors.index', 'bodyClass' => 'vendors-list']);
    $routes->delete('(:num)', 'VendorsController::delete/$1', ['as' => 'vendors.delete']);
    $routes->post('list', 'VendorsController::list', ['as' => 'vendors.list']);
    $routes->post('', 'VendorsController::save', ['as' => 'vendors.save']);
    $routes->post('select2', 'VendorsController::select2', ['as' => 'vendors.select2']);

});

$routes->group('customers', ['filter' => ['isUser', 'isAdmin']], static function ($routes) {
    $routes->get('', 'CustomersController::index', ['as' => 'customers.index', 'bodyClass' => 'customers-list']);
    $routes->delete('(:num)', 'CustomersController::delete/$1', ['as' => 'customers.delete']);
    $routes->post('list', 'CustomersController::list', ['as' => 'customers.list']);
    $routes->post('', 'CustomersController::save', ['as' => 'customers.save']);
    $routes->post('select2', 'CustomersController::select2', ['as' => 'customers.select2']);

});

$routes->group('purchases', ['filter' => ['isUser', 'isAdmin']], static function ($routes) {
    $routes->get('', 'PurchasesController::index', ['as' => 'purchases.index', 'bodyClass' => 'purchases-list']);
    $routes->get('(:num)', 'PurchasesController::get/$1', ['as' => 'purchases.get']);
    $routes->delete('(:num)', 'PurchasesController::delete/$1', ['as' => 'purchases.delete']);
    $routes->post('list', 'PurchasesController::list', ['as' => 'purchases.list']);
    $routes->get('form/(:num)', 'PurchasesController::form/$1', ['as' => 'purchases.edit', 'bodyClass' => 'purchases-form']);
    $routes->get('form', 'PurchasesController::form', ['as' => 'purchases.form', 'bodyClass' => 'purchases-form']);
    $routes->post('', 'PurchasesController::save', ['as' => 'purchases.save']);
});

$routes->group('invoices', ['filter' => ['isUser', 'isAdmin']], static function ($routes) {
    $routes->get('', 'InvoicesController::index', ['as' => 'invoices.index', 'bodyClass' => 'invoices-list']);
    $routes->get('(:num)', 'InvoicesController::get/$1', ['as' => 'invoices.get']);
    $routes->delete('(:num)', 'InvoicesController::delete/$1', ['as' => 'invoices.delete']);
    $routes->post('list', 'InvoicesController::list', ['as' => 'invoices.list']);
    $routes->get('form/(:num)', 'InvoicesController::form/$1', ['as' => 'invoices.edit', 'bodyClass' => 'invoices-form']);
    $routes->get('form', 'InvoicesController::form', ['as' => 'invoices.form', 'bodyClass' => 'invoices-form']);
    $routes->post('', 'InvoicesController::save', ['as' => 'invoices.save']);
});

$routes->group('stocks', ['filter' => ['isUser']], static function ($routes) {
    $routes->get('', 'StocksController::index', ['as' => 'stocks.index', 'bodyClass' => 'stocks-list']);
    $routes->post('list', 'StocksController::list', ['as' => 'stocks.list']);
    $routes->get('calculate', 'StocksController::calculate',['as' => 'stocks.calculate']);
});

$routes->group('reports/sales', ['filter' => ['isUser']], static function ($routes) {
    $routes->get('', 'Reports\SalesReportController::index', ['as' => 'reports.sales.index', 'bodyClass' => 'reports-sales-list']);
    $routes->post('list', 'Reports\SalesReportController::list', ['as' => 'reports.sales.list']);
});

$routes->group('reports/purchase', ['filter' => ['isUser']], static function ($routes) {
    $routes->get('', 'Reports\PurchaseReportController::index', ['as' => 'reports.purchase.index', 'bodyClass' => 'reports-purchase-list']);
    $routes->post('list', 'Reports\PurchaseReportController::list', ['as' => 'reports.purchase.list']);
});