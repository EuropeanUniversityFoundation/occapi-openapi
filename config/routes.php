<?php

use Slim\App;

use App\Action\Occapi\OccapiRootAction;
use App\Action\Occapi\OccapiDefaultAction;
use App\Action\SpecificationAction;

return function (App $app) {
    // Redirect app root to specification root.
    $app->redirect('/', '/specification', 301);

    // Redirect specification root to stable version specification.
    $stable_version = SpecificationAction::STABLE_VERSION;

    $stable_specification = '/specification/' . $stable_version;
    $app->redirect('/specification', $stable_specification, 301);

    // Specification route.
    $app->get('/specification/{version}', SpecificationAction::class)
        ->setName('specification');

    // OCCAPI routes.
    $app->redirect('/occapi', '/occapi/v1', 301);
    $app->get('/occapi/v1', OccapiRootAction::class)
        ->setName('occapi_root');
    $app->get('/occapi/v1/hei[/{params:.*}]', OccapiDefaultAction::class)
        ->setName('occapi_default');
};
