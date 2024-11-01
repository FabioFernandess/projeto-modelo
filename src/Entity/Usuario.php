<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'usuario')]
#[ORM\Entity(repositoryClass: 'App\Repository\UsuarioRepository')]
final class Usuario
{
    #[ORM\Column(name: 'id_usuario', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $idUsuario;

    #[ORM\Column(name: 'nome', type: 'string', length: 30, nullable: false)]
    private string $nomeUsuario;

    /*
     * Getter and Setter
     */
    public function getIdUsuario(): int
    {
        return $this->idUsuario;
    }
    public function setIdUsuario(int $val): void
    {
        $this->idUsuario = $val;
    }
    public function getNome(): string
    {
        return $this->nomeUsuario;
    }
    public function setNome(string $val): void
    {
        $this->nomeUsuario = $val;
    }
}