<?php

declare(strict_types=1);

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

final class AuthController
{
    protected $twig;
    protected $container;

    public function __construct(Twig $twig, ContainerInterface $container)
    {
        $this->twig = $twig;
        $this->container = $container;
    }

    public function autenticar(Request $request, Response $response): Response
    {
        // dd($request->getAttribute('session')['uinfo']);
        if ($request->getMethod() === 'POST') {
            $data = $request->getParsedBody();

            if (empty($data['username']) || empty($data['password'])) {
                return $this->twig->render($response, 'login.twig', ['flash' => ['Empty value in login/password'], 'uinfo' => $request->getAttribute('uinfo')]);
            }

            // Check the user username / pass
            // $uinfo = $this->auth($data['username'], $data['password']);
            // if ($uinfo === null) {
            //     return $this->view->render($response, 'login.twig', ['flash' => ['Invalid login/password'], 'uinfo' => $request->getAttribute('uinfo')]);
            // }

            $_SESSION['logged'] = true;
            $_SESSION['uinfo'] = [
                'idUsuario' => 1,
                'nome' => 'Jhon',
                'idPerfilUsuario' => 1,
            ];
            $tpRetorno = 'success';
            $msgRetorno = '<strong><i class="fa fa-check"></i></strong> Login Efetuado com sucesso, Aguarde você será redirecionado!';
            $codeStatus = 200;
            $classRetorno = 'alert-success';
            $retorno = [
                'dados' => [
                    'url' => '/usuario',
                    'return' => $tpRetorno,
                    'msg' => $msgRetorno,
                    'msgExterna' => '',
                    'class' => $classRetorno,
                    'resetFormulario' => true
                ],
                'codeStatus' => $codeStatus
            ];
            // return $response->withStatus(200)->withHeader('Location', '/');

            $data = array('name' => 'Bob', 'age' => 40);
            $payload = json_encode($data);

            $response->getBody()->write(json_encode($retorno['dados']));
            $response->withStatus($retorno['codeStatus']);
            return $response
                ->withHeader('Content-Type', 'application/json');
        }
        return $this->view->render($response, 'login.twig', ['uinfo' => $request->getAttribute('uinfo')]);
    }

    public function logout(Request $request, Response $response): Response
    {
        $session = $request->getAttribute('session');
        $session['logged'] = false;
        unset($session['uinfo']);
        return $response->withStatus(302)->withHeader('Location', '/');
    }

    private function auth(string $uname, string $pswd): ?\App\Entity\User
    {
        $uinfo = $this->entityManager->getRepository(\App\Entity\User::class)->findOneByUsername($uname);
        if ($uinfo === null) {
            return null;
        }
        if (! password_verify($pswd, $uinfo->getPassword())) {
            return null;
        }

        return $uinfo;
    }
}
