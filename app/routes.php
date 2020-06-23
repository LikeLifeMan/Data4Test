<?php declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->get('/', \App\Actions\HomeAction::class);

    $app->group('/api', function (Group $group) {
        $group->get('/simple/{locale}[/{count}]', \App\Actions\SimpleDataAction::class);
        $group->post('/template/{locale}', \App\Actions\TemplateDataAction::class);
    });

    // system routes
    $app->options('/api/{routes:.+}', \App\Actions\System\CORSPreFlightOptions::class);
};
