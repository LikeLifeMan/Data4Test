<?php declare(strict_types=1);

namespace App\Handlers;

use Exception;
use Psr\Http\Message\ResponseInterface as Response;

use Slim\Handlers\ErrorHandler as SlimErrorHandler;

use Slim\Exception\HttpException;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Exception\HttpNotFoundException;

class HttpErrorHandler extends SlimErrorHandler
{
    protected function respond(): Response
    {
        $result = [];
        $result['code'] = 500;

        $exception = $this->exception;

        if ($exception instanceof HttpException) {
            $result['code'] = $exception->getCode();
            $result['error'] = $exception->getMessage();
        } elseif (($exception instanceof Exception || $exception instanceof Throwable)
          && $this->displayErrorDetails) {
            $result['error'] = $exception->getMessage();
        }

        $response = $this->responseFactory->createResponse($result['code']);
        $response->getBody()->write(json_encode($result));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
