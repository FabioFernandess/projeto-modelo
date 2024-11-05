<?php

namespace App\Service;

use Slim\App;

class AuthService
{

    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getPermissions()
    {
        /*
         * Rotas
         */
        $allRoutes = $this->container->get(App::class)->getRouteCollector()->getRoutes();

        $routes = [];
        foreach ($allRoutes as $route) {
            $routes[] = $route->getPattern();
        }
        /*
         * Perfis Usuários
         */
        $roles[] = 'guest';
        $allow = [
            "guest" => $this->rotasPublicas(),
        ];
        /**
         * PERMISSÕES USUÁRIO
         */
        $sessionUsuario =  $this->container->get('session')->get('uinfo');
        $funcionalidadesLiberadas = $this->container->get('constante')['FUNCIONALIDADE_LIBERADAS'];
        if ($sessionUsuario != null) {
            $roles[] = $sessionUsuario['idPerfil'];
            $rotasPermitidas[] = '/home';

            $permissaoFuncionalidade = $this->container->get(PerfilUsuarioFuncdeService::class)->permissaoFuncionalidade(null,$sessionUsuario['idUsuario'], false, null, null);

            if (count($permissaoFuncionalidade['funcionalidade']) > 0) {
                foreach ($permissaoFuncionalidade['funcionalidade'] as $func) {
                    if (in_array($func['descUrl'], $funcionalidadesLiberadas)) {
                        if ($func['operacao'] == 'consultar') {
                            $rotasPermitidas[] = $func['descUrl'];
                            $rotasPermitidas[] = $func['descUrl'] . '/get';
                            // $rotasPermitidas[] = $func['descUrl'] . '/exportarXls';
                            // $rotasPermitidas[] = $func['descUrl'] . '/exportarPdf';
                           
                        }
                        if ($func['operacao'] == 'incluir') {
                           
                            $rotasPermitidas[] = $func['descUrl'] . '/post';
                        }

                        if ($func['operacao'] == 'alterar') {
                            $rotasPermitidas[] = $func['descUrl'] . '/put';
                           
                        }

                        if ($func['operacao'] == 'excluir') {
                            $rotasPermitidas[] = $func['descUrl'] . '/delete';
                         
                        }
                    }
                }
            }
            //            echo '<pre>';
            //            print_r($rotasPermitidas);
            //            echo '</pre>';
            //            die();
            $allow[$sessionUsuario['idPerfil']] = $rotasPermitidas;
        }
        /*
         * Permissões
         */
        return [
            "resources" => $routes,
            "roles" => $roles,
            "assignments" => [
                "allow" => $allow,
                "deny" => []
            ]
        ];
    }

    private function rotasPublicas()
    {
        return [
            '/login',
            '/autenticar',
            '/4xx',
            '/401',
            '/403',
            '/404',
            '/500',
        ];
    }
}
