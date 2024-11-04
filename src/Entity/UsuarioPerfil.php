<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[ORM\Table(name: 'usuario_perfil')]
#[ORM\Entity(repositoryClass: 'App\Repository\UsuarioPerfilRepository')]
final class UsuarioPerfil
{
    #[ORM\Column(name: 'id_usuario_perfil', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $idUsuarioPerfil;

    #[ManyToOne(targetEntity: Usuario::class)]
    #[JoinColumn(name: 'id_usuario', referencedColumnName: 'id_usuario')]
    private Usuario|null $usuario = null;


    #[ManyToOne(targetEntity: PerfilUsuario::class)]
    #[JoinColumn(name: 'id_perfil_usuario', referencedColumnName: 'id_perfil_usuario')]
    private PerfilUsuario|null $perfilUsuario = null;



    public function getIdUsuarioPerfil(): int
    {
        return $this->idUsuarioPerfil;
    }
    public function setIdUsuarioPerfil(int $val): void
    {
        $this->idUsuarioPerfil = $val;
    }

    public function getUsuario(): Usuario
    {
        return $this->usuario;
    }
    public function setUsuario(Usuario $val): void
    {
        $this->usuario = $val;
    }
    public function getPerfilUsuario(): PerfilUsuario
    {
        return $this->perfilUsuario;
    }
    public function setPerfilUsuario(PerfilUsuario $val): void
    {
        $this->perfilUsuario = $val;
    }

}