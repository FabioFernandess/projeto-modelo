<?php

namespace App\Service;

use App\Entity\PerfilUsuarioFuncde;
use Doctrine\ORM\EntityManager;
use Slim\App;

class PerfilUsuarioFuncdeService
{

    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * 
     * 
     * @return \App\Repository\PerfilUsuarioFuncdeRepository
     */
    private function getRepository()
    {
        return $this->container->get(EntityManager::class)->getRepository(PerfilUsuarioFuncde::class);
    }

    public function permissaoFuncionalidade($idFuncde, $idUsuario, $menu, $idUnidade = null, $idPerfil = null)
    {
        return $this->getRepository()->permissaoFuncionalidade($this->container, $idFuncde, $idUsuario, $menu, $idUnidade, $idPerfil);
    }

    public function menuUsuario()
    {
        $menu = $this->container->get('menu');
        $rotaPermitida = [];

        $idUsuario = null;
        if ($this->container->get('session')->get('uinfo')) {
            $idUsuario = $this->container->get('session')->get('uinfo')['idUsuario'];
        }
        $funcionalidadesLiberadas = $this->container->get('constante')['FUNCIONALIDADE_LIBERADAS'];
        $permissaoFuncionalidade = $this->getRepository()->permissaoFuncionalidade($this->container, null, $idUsuario, true, null, null);

        if (count(value: $permissaoFuncionalidade['funcionalidade']) > 0) {
            foreach ($permissaoFuncionalidade['funcionalidade'] as $permi) {
                if (in_array($permi['descUrl'], $funcionalidadesLiberadas)) {
                    foreach ($this->container->get('constante')['ROTA_MENU_FUNCIONALIDADE'][$permi['idFuncionalidade']] as $val) {
                        $rotaPermitida[$val] = $val;
                    }
                }
            }
        }
        /**
         * remove indices não liberados
         */
        foreach ($menu as $key => $value) {
            if (!in_array($key, $rotaPermitida)) {
                unset($menu[$key]);
            } else {
                if (count($value['sub_menu']) > 0) {
                    foreach ($value['sub_menu'] as $key2 => $value2) {
                        if (!in_array($key2, $rotaPermitida)) {
                            unset($menu[$key]['sub_menu'][$key2]);
                        } else {
                            if (count($value2['sub_menu']) > 0) {
                                foreach ($value2['sub_menu'] as $key3 => $value3) {
                                    if (!in_array($key3, $rotaPermitida)) {
                                        unset($menu[$key]['sub_menu'][$key2]['sub_menu'][$key3]);
                                    } else {
                                        if (count($value3['sub_menu']) > 0) {
                                            foreach ($value3['sub_menu'] as $key4 => $value4) {
                                                if (!in_array($key4, $rotaPermitida)) {
                                                    unset($menu[$key]['sub_menu'][$key2]['sub_menu'][$key3]['sub_menu'][$key4]);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $menu;
    }
}
