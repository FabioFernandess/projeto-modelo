<?php
declare(strict_types=1);

use App\Middleware\BaseUrlMiddleware;
use App\Middleware\SessionMiddleware;
use App\Service\Settings;
use Geggleto\Acl\AclRepository;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\App;
use Slim\Psr7\Request;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Tracy\Debugger;

return static function (App $app, Request $request, RequestHandler $handler) {
    $container = $app->getContainer();
    
    // Example: Check for a specific header before proceeding
    $auth = $request->getHeaderLine('Authorization');
    
    $response = $app->getResponseFactory()->createResponse();

    $authService = $container->get('authService')->getPermissions();

    $tpRota = null;
    if ($request->getAttribute('route'))
        $tpRota = explode('.', $request->getAttribute('route')->getName());

    $urlAtual = $request->getUri()->getPath();

    /**
     * Verifica rota com parâmetro para fechar
     */
    if (
        strpos($urlAtual, 'edit') ||
        strpos($urlAtual, 'view') ||
        strpos($urlAtual, 'create')
    ) {
        $explode = explode("/", $urlAtual);
        if (isset($explode[3])) {
            $urlAtual = str_replace('/' . $explode[3], '[/{id}]', $urlAtual);
        }
    }

    /** @var object AclRepository */
    $aclRepo = new AclRepository($authService['roles'], $authService);
    $allowed = false;
    $route = '/' . ltrim($urlAtual, '/');
    try {
        $allowed = $aclRepo->isAllowedWithRoles($aclRepo->getRole(), $route);
    } catch (InvalidArgumentException $iae) { //This is executed in cases where there is a route parameters... /user/{id:}
        $fn = function (ServerRequestInterface $requestInterface, AclRepository $aclRepo) {
            $route = $requestInterface->getAttribute('route'); // Grab the route to get the pattern
            if (!empty($route)) {
                foreach ($aclRepo->getRole() as $role) {
                    if ($aclRepo->isAllowed($role, $route->getPattern())) { // check to see fi the user can access the pattern
                        return true; //Is allowed
                    }
                }
            }
            return false;
        };

        $allowed = $fn($request, $aclRepo);
    }
    if ($allowed) {
        return $handler->handle($request);
    } else {
        $statusCode = $request->getMethod() == 'GET' ? 301 : 403;
        if ($_SESSION['uinfo'] == null) {
            $response->getBody()->write($container->get(Twig::class)->fetch('login.twig'));
            return $response->withStatus(200);
        }
        $response->getBody()->write($container->get(Twig::class)->fetch('403.twig'));

        return $response->withStatus(200);
    }
};
