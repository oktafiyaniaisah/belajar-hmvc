<?php
$routes->group('produk', ['namespace' => 'Modules\Produk\Controllers'], function($routes) {
    $routes->get('/', 'Produk::index');
    $routes->get('getData', 'Produk::getData');
    $routes->post('simpan', 'Produk::simpan');
    $routes->get('getById/(:num)', 'Produk::getById/$1');
    $routes->post('update', 'Produk::update');
    $routes->delete('delete/(:num)', 'Produk::delete/$1');
});