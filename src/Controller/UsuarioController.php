<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

final class UsuarioController
{
    public function __construct(
        private Twig $view,
    ) {
    }

    public function index(Request $request, Response $response): Response
    {
        return $this->view->render($response, 'app/usuario/index.twig');
    }

    public function create(Request $request, Response $response): Response
    {
        return $this->view->render($response, 'app/usuario/form.twig',[
            'config'=>[
                'method'=>'post',
                'action'=>'app.usuario.post',
                'urlVoltar' => 'app.usuario.index'
            ]
        ]);
    }

   
}
