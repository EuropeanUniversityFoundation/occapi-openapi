<?php

use Slim\App;

return function (App $app) {
    $app->get('/', \App\Action\HomeAction::class)->setName('home');

    // OCCAPI routes.
    $app->redirect('/occapi', '/occapi/v1', 301);
    $app->get('/occapi/v1', \App\Action\Occapi\OccapiRootAction::class)
        ->setName('occapi_root');
    $app->get('/occapi/v1/hei[/{params:.*}]', \App\Action\Occapi\OccapiDefaultAction::class)
        ->setName('occapi_default');
};
