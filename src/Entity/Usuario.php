<?php

declare(strict_types=1);

namespace App\Entity;

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

    #[ORM\Column(name: 'username', type: 'string', length: 100, nullable: false)]
    private string $username;

    #[ORM\Column(name: 'password', type: 'string', length: 200, nullable: false)]
    private string $password;

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
    public function getUsername(): string
    {
        return $this->username;
    }
    public function setUsername(string $val): void
    {
        $this->username = $val;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function setPassword(string $val): void
    {
        $this->password = $val;
    }
}
