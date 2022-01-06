<?php

namespace App\Action\Occapi;

use App\Action\Occapi\OccapiRootAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Selective\Validation\Exception\ValidationException;
use Selective\Validation\ValidationResult;

final class OccapiDefaultAction
{
    /**
     * @var ValidationResult
     */
    private $validation;

    /**
     * The constructor.
     */
    public function __construct() {
        $this->validation = new ValidationResult();
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        $data_path = OccapiRootAction::DATA_DIR . '/hei/';

        if ($args) {
          $params = explode('/', $args['params']);
          $subpath = implode('/', $params);
          $subpath = (sizeof($args) === 1) ? $subpath . '/' : $subpath ;
          $data_path .= $subpath;
        }

        // Validate file path
        if (! \file_exists($data_path . OccapiRootAction::FILENAME)) {
            $this->validation->addError('path', 'Invalid API path.');
        }

        // Check validation result
        if ($this->validation->fails()) {
            // Trigger the validation middleware
            throw new ValidationException('Invalid API path', $this->validation);
        }

        $json = \file_get_contents($data_path . OccapiRootAction::FILENAME);
        $response->getBody()->write($json);
        $response = $response
          ->withHeader('Content-Type', 'application/vnd.api+json');
        return $response;
    }
}
