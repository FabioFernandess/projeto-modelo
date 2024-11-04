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


    private function getRepository()
    {
        return $this->container->get(EntityManager::class)->getRepository(PerfilUsuarioFuncde::class);
    }

    public function permissaoFuncionalidade($idFuncde, $idUsuario, $menu, $idUnidade = null, $idPerfil = null) {
        return $this->getRepository()->permissaoFuncionalidade($this->container,$idFuncde, $idUsuario, $menu, $idUnidade, $idPerfil);
    }
}
