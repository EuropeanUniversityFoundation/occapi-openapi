<?php

use Middlewares\TrailingSlash;
use Selective\Validation\Middleware\ValidationExceptionMiddleware;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;

return function (App $app) {
    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    // Add the Slim built-in routing middleware
    $app->addRoutingMiddleware();

    // Catch exceptions and errors
    $app->add(ErrorMiddleware::class);

    // Strip trailing slash
    $app->add(new TrailingSlash(false));

    // Add Validation
    $app->add(ValidationExceptionMiddleware::class);
};
