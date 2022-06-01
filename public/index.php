<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\NewsController;
use Controllers\UsersController;
use Controllers\PaginasController;
use Controllers\ExperienciasController;
use Controllers\FormacionesController;

//Muestra la clase y su namespace
//echo '<pre>';
//var_dump(NewsController::class);
//echo '</pre>';

$router = new Router();

//pasamos la ruta y un array con la clase/namespace y su método estático
//ADMIN BLOG
$router->get('/admin', [NewsController::class, 'admin']);
$router->post('/admin', [NewsController::class, 'admin']);
$router->get('/admin/crear', [NewsController::class, 'crear']);
$router->post('/admin/crear', [NewsController::class, 'crear']);
$router->get('/admin/actualizar', [NewsController::class, 'actualizar']);
$router->post('/admin/actualizar', [NewsController::class, 'actualizar']);
$router->post('/admin/eliminar', [NewsController::class, 'eliminar']);

//AUTENTICACIÓN
$router->get('/blog/login', [UsersController::class, 'login']);
$router->post('/blog/login', [UsersController::class, 'login']);
$router->get('/blog/salir', [UsersController::class, 'salir']);
$router->get('/administrador/salir', [UsersController::class, 'salir']);
$router->get('/blog/registro', [UsersController::class, 'registro']);
$router->post('/blog/registro', [UsersController::class, 'registro']);

//Páginas públicas blog
$router->get('/blog', [PaginasController::class, 'blog']);
$router->get('/blog/entrada', [PaginasController::class, 'entrada']);
$router->post('/blog/entrada', [PaginasController::class, 'entrada']);

//Páginas públicas CV
$router->get('/', [PaginasController::class, 'index']);
$router->get('/sobre-mi', [PaginasController::class, 'sobremi']);
$router->get('/formacion', [PaginasController::class, 'formacion']);
$router->get('/experiencia', [PaginasController::class, 'experiencia']);
$router->get('/contacto', [PaginasController::class, 'contacto']);
$router->post('/contacto', [PaginasController::class, 'contacto']);
$router->get('/administrador', [PaginasController::class, 'admin']);

//ADMIN CRUD CV
$router->get('/experiencias/index', [ExperienciasController::class, 'index']);
$router->get('/experiencias/crear', [ExperienciasController::class, 'crear']);
$router->post('/experiencias/crear', [ExperienciasController::class, 'crear']);
$router->get('/experiencias/actualizar', [ExperienciasController::class, 'actualizar']);
$router->post('/experiencias/actualizar', [ExperienciasController::class, 'actualizar']);
$router->post('/experiencias/eliminar', [ExperienciasController::class, 'eliminar']);
$router->get('/formaciones/index', [FormacionesController::class, 'index']);
$router->get('/formaciones/crear', [FormacionesController::class, 'crear']);
$router->post('/formaciones/crear', [FormacionesController::class, 'crear']);
$router->get('/formaciones/actualizar', [FormacionesController::class, 'actualizar']);
$router->post('/formaciones/actualizar', [FormacionesController::class, 'actualizar']);
$router->post('/formaciones/eliminar', [FormacionesController::class, 'eliminar']);

$router->comprobarRutas();
