<?php declare(strict_types=1);

namespace App\Actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Slim\Exception\HttpException;

use App\Utils\Action;
use App\Utils\DataFiller;

class TemplateDataAction extends Action
{
    public function action(Request $request, Response &$response, array $args = []): array
    {
        $locale = array_key_exists('locale', $args) ? $args['locale'] : null;
        $template = (array)$request->getParsedBody();

        abort_if(empty($template), $request, "Template Is Empty Or Json Format Error", 400);

        return DataFiller::makeTemplate($locale, $template);
    }
}
