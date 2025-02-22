<?php declare(strict_types=1);

namespace App\Actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// CORS Pre-Flight OPTIONS Request Handler
class CORSPreFlightOptions
{
    public function __invoke(Request $request, Response $response): Response
    {
        return $response;
    }
}
