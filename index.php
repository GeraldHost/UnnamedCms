<?php
namespace Cms;

require __DIR__ . '/vendor/autoload.php';

$dotenv = new \Dotenv\Dotenv(__DIR__);
$dotenv->load();

$app = new Src\Application;
$cms = $app->make("Cms\\Src\\Cms");

require __DIR__ . '/cms.php';

$app->bootstrap();

$router = $app->make('Cms\\Src\\Router\\Router');
$router->dispatch();