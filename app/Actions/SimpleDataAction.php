<?php declare(strict_types=1);

namespace App\Actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Slim\Exception\HttpException;

use App\Utils\Action;
use App\Utils\DataFiller;

class SimpleDataAction extends Action
{
    public function action(Request $request, Response &$response, array $args = []): array
    {
        $locale = array_key_exists('locale', $args) ? $args['locale'] : null;
        $count = array_key_exists('count', $args) ? (int)filter_var($args['count'], FILTER_SANITIZE_NUMBER_INT) : 1;
        $params = $request->getQueryParams();

        abort_if(count($params) < 1, $request, 'Params Not Found', 400);

        return DataFiller::make($locale, $count, $params);
    }
}
