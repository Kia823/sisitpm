<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

define('RUTA_NUCLEO', __DIR__.'/core');
define('RUTA_PUBLICO', '/home/vol1000_3/infinityfree.com/if0_43088437/htdocs');

$rutaNucleo  = RUTA_NUCLEO;
$rutaPublico = RUTA_PUBLICO;

if (file_exists($maintenance = $rutaNucleo.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $rutaNucleo.'/vendor/autoload.php';

/** @var \Illuminate\Foundation\Application $app */
$app = require_once $rutaNucleo.'/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle($request = Request::capture())->send();

$kernel->terminate($request, $response);
