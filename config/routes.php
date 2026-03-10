<?php

use Slim\App;

use App\Action\Occapi\OccapiRootAction;
use App\Action\Occapi\OccapiDefaultAction;
use App\Action\SpecificationAction;

return function (App $app) {
    // Redirect app root to specification root.
    $app->redirect('/', '/specification', 301);

    // Redirect specification root to current version specification.
    $current_version = SpecificationAction::CURRENT_VERSION;

    $current_specification = '/specification/' . $current_version;
    $app->redirect('/specification', $current_specification, 301);

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
