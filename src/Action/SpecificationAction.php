<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

final class SpecificationAction
{
    const ALL_VERSIONS = [
        'v1',
        'v2',
    ];

    const STABLE_VERSION = 'v1';
    const LATEST_VERSION = 'v2';

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args,
    ): ResponseInterface {
        $version = strtolower($args['version']);

        if (!in_array($version, self::ALL_VERSIONS)) {
            throw new HttpNotFoundException($request);
        }

        $view = Twig::fromRequest($request);

        $vars = ['version' => $version];

        if (self::STABLE_VERSION !== self::LATEST_VERSION) {
            if ($version !== self::STABLE_VERSION) {
                $vars['has_stable'] = self::STABLE_VERSION;
            }

            if ($version !== self::LATEST_VERSION){
                $vars['has_latest'] = self::LATEST_VERSION;
            }
        }

        return $view->render($response, 'index.html', $vars);
    }
}
