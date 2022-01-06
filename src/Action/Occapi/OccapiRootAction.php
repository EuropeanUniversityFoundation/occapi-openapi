<?php

namespace App\Action\Occapi;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class OccapiRootAction
{
    const DATA_DIR = __DIR__ . '/../../../data/v1/';
    const FILENAME = 'index.json';

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $data_path = self::DATA_DIR;
        $json_data = \file_get_contents($data_path . self::FILENAME);
        $response->getBody()->write($json_data);
        $response = $response
          ->withHeader('Content-Type', 'application/vnd.api+json');
        return $response;
    }
}
