<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// Workshop 5 - CRUD de productos

// Mostrar todos los productos
$routes->get('productos', 'Productos::index');

// Mostrar formulario para crear
$routes->get('productos/crear', 'Productos::crear');

// Guardar un producto nuevo
$routes->post('productos/guardar', 'Productos::guardar');

// Mostrar formulario para editar
$routes->get('productos/editar/(:num)', 'Productos::editar/$1');

// Actualizar producto
$routes->post('productos/actualizar/(:num)', 'Productos::actualizar/$1');

// Eliminar producto
$routes->post('productos/eliminar/(:num)', 'Productos::eliminar/$1');// Mostrar formulario de nuevo producto

$routes->get('productos/nuevo', 'Productos::nuevo');