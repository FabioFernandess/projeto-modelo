<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'perfil_usuario')]
#[ORM\Entity(repositoryClass: 'App\Repository\PerfilUsuarioRepository')]
final class PerfilUsuario
{
    #[ORM\Column(name: 'id_perfil_usuario', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $idPerfilUsuario;

    #[ORM\Column(name: 'nome_perfil', type: 'string', length: 150, nullable: false)]
    private string $nomePerfil;


    #[ORM\Column(name: 'desc_perfil', type: 'string', length: 500, nullable: false)]
    private string $descPerfil;

    #[ORM\Column(name: 'stat_perfil', type: 'string', length: 1, nullable: false)]
    private string $statPerfil;

    /*
     * Getter and Setter
     */
    public function getIdPerfilUsuario(): int
    {
        return $this->idPerfilUsuario;
    }
    public function setIdPerfilUsuario(int $val): void
    {
        $this->idPerfilUsuario = $val;
    }
    public function getNomePerfil(): string
    {
        return $this->nomePerfil;
    }
    public function setNomePerfil(string $val): void
    {
        $this->nomePerfil = $val;
    }

    public function getDescPerfil(): string
    {
        return $this->descPerfil;
    }
    public function setDescPerfil(string $val): void
    {
        $this->descPerfil = $val;
    }

    public function getStatPerfil(): string
    {
        return $this->statPerfil;
    }
    public function setStatPerfil(string $val): void
    {
        $this->statPerfil = $val;
    }
}