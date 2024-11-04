<?php

declare(strict_types=1);

use App\Service\Settings;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return static function (App $app): void {
    $app->get('/', callable: [\App\Controller\HomeController::class, 'index'])->setName('home');
    $app->get('/home', callable: [\App\Controller\HomeController::class, 'index'])->setName('home');
    $app->get('/login', callable: [\App\Controller\HomeController::class, 'index'])->setName('app.home.index');
    $app->post('/autenticar', callable: [\App\Controller\AuthController::class, 'autenticar'])->setName('app.autenticar');
    $app->get('/401', callable: [\App\Controller\HomeController::class, 'index'])->setName('app.home.index');
    $app->get('/403', callable: [\App\Controller\HomeController::class, 'index'])->setName('app.home.index');
    $app->get('/404', callable: [\App\Controller\HomeController::class, 'index'])->setName('app.home.index');
    $app->get('/4xx', callable: [\App\Controller\HomeController::class, 'index'])->setName('app.home.index');
    $app->get('/500', callable: [\App\Controller\HomeController::class, 'index'])->setName('app.home.index');


    $app->get('/usuario', [\App\Controller\HomeController::class, 'index'])->setName('home');
    $app->get('/usuario/post', [\App\Controller\HomeController::class, 'create'])->setName('home');
    $app->get('/usuario/put', [\App\Controller\HomeController::class, 'create'])->setName('home');
    $app->get('/usuario/get', [\App\Controller\HomeController::class, 'create'])->setName('home');
    $app->get('/usuario/create', [\App\Controller\HomeController::class, 'create'])->setName('home');
    $app->get('/usuario/delete', [\App\Controller\HomeController::class, 'delete'])->setName('home');
    $app->get('/usuario/save', [\App\Controller\HomeController::class, 'save'])->setName('home');

    // $app->get('/api_info', [\App\Controller\HomeController::class, 'apiInfo'])->setName('apiInfo');
    // $app->get('/error', [\App\Controller\HomeController::class, 'error'])->setName('error');

    // $app->get('/blog/{id}', [\App\Controller\BlogController::class, 'view'])->setName('blog');

    // $app->group('/member', static function (Group $group): void {
    //     $group->map(['GET', 'POST'], '/login', [\App\Controller\AuthController::class, 'login'])->setName('login');
    //     $group->get('/logout', [\App\Controller\AuthController::class, 'logout'])->setName('logout');
    // });

    // $app->group('/api', static function (Group $group): void {
    //     $group->get('/post', [\App\Controller\Api\PostController::class, 'getAll'])->setName('apiPostGetAll');
    //     $group->get('/post/{id}', [\App\Controller\Api\PostController::class, 'get']);
    //     $group->post('/post', [\App\Controller\Api\PostController::class, 'add']);
    //     $group->delete('/post/{id}', [\App\Controller\Api\PostController::class, 'delete']);
    // });

    $settings = $app->getContainer()->get(Settings::class);
    if ($settings->get('debug') && $settings->get('tracy.configs.ConsoleEnable')) {
        $app->post('/console', 'SlimTracy\Controllers\SlimTracyConsole:index');
    }

    // Not Found
    $app->map(
        ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
        '/{routes:.*}',
        static function (Request $request): void {
            throw new Slim\Exception\HttpNotFoundException($request);
        }
    );
};
