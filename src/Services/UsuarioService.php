<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Usuario;

final class UsuarioService
{

    
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }
    
    
    private function getRepository()
    {
        return $this->container->get('em')->getRepository(Usuario::class);
    }

    public function buscarUsuarios(){
        return $this->getRepository()->buscarUsuarios();
    }
}