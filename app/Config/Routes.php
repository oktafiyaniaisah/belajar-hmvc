<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


// Load routes dari semua modul secara otomatis
if (is_dir(ROOTPATH . 'Modules')) {
    $modulesPath = ROOTPATH . 'Modules';
    $dir = new \DirectoryIterator($modulesPath);

    foreach ($dir as $fileinfo) {
        if ($fileinfo->isDir() && !$fileinfo->isDot()) {
            $routesPath = $modulesPath . '/' . $fileinfo->getFilename() . '/Config/Routes.php';
            if (file_exists($routesPath)) {
                require $routesPath;
            }
        }
    }
}

