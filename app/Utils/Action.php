<?php declare(strict_types=1);

namespace App\Utils;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

abstract class Action
{
    abstract public function action(Request $request, Response &$response, array $args = []): array;

    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $data = $this->action($request, $response, $args);

        // build response
        $response->getBody()->write(json_encode($data, JSON_PRETTY_PRINT));

        return $response
          ->withHeader('Content-Type', 'application/json')
          ->withStatus(200);
    }
}
