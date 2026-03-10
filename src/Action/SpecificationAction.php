<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;

final class SpecificationAction
{
    const ALL_VERSIONS = [
        'v1' => 'deprecated',
        'v2' => 'beta',
    ];

    const CURRENT_VERSION = 'v2';

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args,
    ): ResponseInterface {
        $requested = strtolower($args['version']);

        if (!array_key_exists($requested, self::ALL_VERSIONS)) {
            throw new HttpNotFoundException($request);
        }

        $view = Twig::fromRequest($request);

        $vars = [
            'version' => $requested,
            'current' => self::CURRENT_VERSION,
        ];

        $vars['links'] = [];

        foreach (self::ALL_VERSIONS as $version => $stability) {
            if ($version !== $requested) {
                $vars['links'][] = [
                    'version' => $version,
                    'stability' => $stability,
                ];
            }
        }

        return $view->render($response, 'index.html', $vars);
    }
}
