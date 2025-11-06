<?php
require '../vendor/autoload.php';

$uri = $_SERVER['REQUEST_URI'];
$router = new AltoRouter();

$router->map('GET', '/', 'home', 'home');
$router->map('GET', '/charts', 'charts', 'charts');
$router->map('GET', '/schedule', 'schedule', 'schedule');
$router->map('GET', '/team', 'team', 'team');
$router->map('GET', '/benevolat', 'benevolat', 'benevolat');
$router->map('GET', '/privacy-policy', 'privacy-policy', 'privacy-policy');
$router->map('GET', 'pages/[*:slug]', 'single_page', 'single_page');

$router->map('GET', '/posts/[i:id]', 'single_post', 'single_post');
$router->map('GET', '/shows/[i:id]', 'single_show', 'single_show');
$router->map('GET', '/profile/[i:id]', 'profile', 'profile');

$match = $router->match();
