<?php declare(strict_types=1);

namespace App\Actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeAction
{
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        ob_start();
        require(__DIR__.'/../Templates/HomePage.php');
        $response->getBody()->write(ob_get_clean());
        return $response;
    }
}
