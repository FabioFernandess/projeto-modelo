<?php

declare(strict_types=1);

namespace App\Controller;

use App\Services\TesteService;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\Twig;

final class HomeController
{
    protected $twig;

    protected $container;

    public function __construct(Twig $twig,ContainerInterface $container)
    {
        $this->twig = $twig;
        $this->container = $container;

    }


    public function __invoke(Request $request, Response $response, string $name = ''): ResponseInterface
    {
        return $this->twig->render($response, 'homepage.html.twig', [
            'name' => $name
        ]);
    }

    public function index(Request $request, Response $response){
        dd($this->container->get('usuarioService')->buscarUsuarios());
        return $this->twig->render($response, 'login.twig', [
            'name' => ''
        ]);
    }


}
