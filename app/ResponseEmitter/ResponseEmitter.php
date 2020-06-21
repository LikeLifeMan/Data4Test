<?php
declare(strict_types=1);

namespace App\ResponseEmitter;

use Psr\Http\Message\ResponseInterface;
use Slim\ResponseEmitter as SlimResponseEmitter;

class ResponseEmitter extends SlimResponseEmitter
{
    /**
     * {@inheritdoc}
     */
    public function emit(ResponseInterface $response): void
    {
        $contentType = $response->getHeader('Content-Type');
        $contentType = is_array($contentType) && count($contentType)>0 ? $contentType[0] : '';
        if ($contentType === 'application/json') {
            // This variable should be set to the allowed host from which your API can be accessed with
            //$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
            $origin = rtrim(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '', "/");

            $response = $response
              ->withHeader('Access-Control-Allow-Credentials', 'true')
              ->withHeader('Access-Control-Allow-Origin', $origin)
              ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
              ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
              ->withHeader('Access-Control-Expose-Headers', 'Content-Length, X-JSON')
              ->withHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
              ->withAddedHeader('Cache-Control', 'post-check=0, pre-check=0')
              ->withHeader('Pragma', 'no-cache');
        }

        if (ob_get_contents()) {
            ob_clean();
        }
        
        parent::emit($response);
    }
}
