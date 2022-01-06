<?php

namespace App\Action\Occapi;

use App\Action\Occapi\OccapiRootAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class OccapiDefaultAction
{
    const ENDPOINT_404 = 'endpoint.json';
    const RESOURCE_404 = 'resource.json';

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        $data_path = OccapiRootAction::DATA_DIR . '/hei/';
        $error_path = OccapiRootAction::DATA_DIR . '/404/';

        if ($args) {
          $params = explode('/', $args['params']);
          $subpath = implode('/', $params);
          $subpath = (sizeof($args) === 1) ? $subpath . '/' : $subpath ;
          $data_path .= $subpath;
        }

        // Validate file path
        if (! \file_exists($data_path . OccapiRootAction::FILENAME)) {
            if (\count($params) % 2 === 0) {
              $json = \file_get_contents($error_path . self::ENDPOINT_404);
            } else {
              $json = \file_get_contents($error_path . self::RESOURCE_404);
            }
        }
        else {
          $json = \file_get_contents($data_path . OccapiRootAction::FILENAME);
        }

        $response->getBody()->write($json);
        $response = $response
          ->withHeader('Content-Type', 'application/vnd.api+json');
        return $response;
    }
}
