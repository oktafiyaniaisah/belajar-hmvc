<?php
$routes->group('produk', ['namespace' => 'Modules\Produk\Controllers'], function($routes) {
    $routes->get('/', 'Produk::index');
    $routes->get('getData', 'Produk::getData');
    $routes->post('simpan', 'Produk::simpan');
});