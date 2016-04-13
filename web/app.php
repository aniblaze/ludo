<?php

use Symfony\Component\HttpFoundation\Request;

/**
 * @var Composer\Autoload\ClassLoader
 */
$loader = require __DIR__.'/../app/autoload.php';
include_once __DIR__.'/../var/bootstrap.php.cache';

$environment = getenv('APP_ENV');

if (!($environment))
{
    $environment = 'dev';
    Debug::enable();
}

$debug = ($environment === 'dev');

$kernel = new AppKernel($environment, $debug);
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
