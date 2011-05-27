<?php
require_once __DIR__ . '/silex.phar';

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

$app = new Silex\Application(); 

$app->register(new Silex\Extension\MonologExtension(), array(
    'monolog.logfile'       => __DIR__.'/development.log',
    'monolog.class_path'    => __DIR__.'/vendor/monolog/src',
    'monolog.name'          => 'silex-demo',
));

/**
 * API
 *
 * POST
 * /login
 * /register
 * /profile
 * /profile/image
 * /messages
 *
 * GET
 * /users
 * /profile
 * /messages
 *
 */
$app->get('/register/{email}', function($email) {
    return "Hello $email";
});



$app->error(function (\Exception $e) {
    if ($e instanceof NotFoundHttpException) {
        return new Response('The requested page could not be found.', 404);
    }

    $code = ($e instanceof HttpException) ? $e->getStatusCode() : 500;
    return new Response('We are sorry, but something went terribly wrong.', $code);
});


//$app['monolog']->addDebug('Testing the Monolog logging.');
$app->run();