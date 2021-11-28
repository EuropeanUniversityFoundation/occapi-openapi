<?php

use Slim\App;
use Slim\Views\Twig;

use App\Action\Occapi\OccapiRootAction;
use App\Action\Occapi\OccapiDefaultAction;

return function (App $app) {
    $app->get('/', function ($request, $response, $args) {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'index.html');
    })->setName('root');


    // OCCAPI routes.
    $app->redirect('/occapi', '/occapi/v1', 301);
    $app->get('/occapi/v1', OccapiRootAction::class)
        ->setName('occapi_root');
    $app->get('/occapi/v1/hei[/{params:.*}]', OccapiDefaultAction::class)
        ->setName('occapi_default');
};
