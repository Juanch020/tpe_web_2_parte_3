<?php

require_once './libs/router/router.php';
require_once './libs/jwt/jwt_middleware.php';

require_once './app/middlewares/guard_api_middleware.php';

require_once './app/controllers/auth_api_controller.php';
require_once './app/controllers/jugador_api_controller.php';
require_once './app/controllers/equipo_api_controller.php';
require_once './app/controllers/posicion_api_controller.php';

$router = new Router();

/*
| Middleware JWT
*/
$router->addMiddleware(new JWTMiddleware());

/*
| Auth
*/
$router->addRoute('auth/login', 'POST', 'AuthApiController', 'login');

/*
| Jugadores
*/
$router->addRoute('jugadores', 'GET', 'JugadorApiController', 'getJugadores');
$router->addRoute('jugadores/:id', 'GET', 'JugadorApiController', 'getJugador');

/*
| Equipos
*/
$router->addRoute('equipos', 'GET', 'EquipoApiController', 'getAll');
$router->addRoute('equipos/:id', 'GET', 'EquipoApiController', 'getEquipo');

/*
| Posiciones
*/
$router->addRoute('posiciones', 'GET', 'PosicionApiController', 'getAll');
$router->addRoute('posiciones/:id', 'GET', 'PosicionApiController', 'getPosicion');

/*
| Rutas protegidas
*/
$router->addMiddleware(new GuardMiddleware());

/*
| Jugadores
*/
$router->addRoute('jugadores', 'POST', 'JugadorApiController', 'addJugador');
$router->addRoute('jugadores/:id', 'PUT', 'JugadorApiController', 'updateJugador');
$router->addRoute('jugadores/:id', 'DELETE', 'JugadorApiController', 'deleteJugador');

/*
| Equipos
*/
$router->addRoute('equipos', 'POST', 'EquipoApiController', 'addEquipo');
$router->addRoute('equipos/:id', 'PUT', 'EquipoApiController', 'updateEquipo');
$router->addRoute('equipos/:id', 'DELETE', 'EquipoApiController', 'deleteEquipo');

/*
| Posiciones
*/
$router->addRoute('posiciones', 'POST', 'PosicionApiController', 'addPosicion');
$router->addRoute('posiciones/:id', 'PUT', 'PosicionApiController', 'updatePosicion');
$router->addRoute('posiciones/:id', 'DELETE', 'PosicionApiController', 'deletePosicion');

$router->route(
    $_GET['resource'],
    $_SERVER['REQUEST_METHOD']
);