<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/reservar', 'ReservaController@reservar');
$router->get('/reservas', 'ReservaController@reservas');
$router->get('/register', 'UserController@register');
$router->get('/quartos', 'QuartoController@quartos');
$router->post('/reservarquarto', 'ReservaController@reservarQuarto');
$router->get('/minhasreservas', 'ReservaController@minhasReservas');
$router->post('/registro', 'UserController@registerAction');
$router->post('/login', 'UserController@loginAction');
$router->get('/login', 'UserController@index');
$router->get('/forgot-password', 'UserController@forgotPassword');
$router->post('/send-verification-code', 'UserController@sendVerificationCode');
$router->post('/verify-code', 'UserController@verifyCode');
$router->post('/reset-password', 'UserController@resetPassword');