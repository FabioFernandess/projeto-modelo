<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'funcionalidade')]
#[ORM\Entity(repositoryClass: 'App\Repository\FuncionalidadeRepository')]
final class Funcionalidade
{
    #[ORM\Column(name: 'id_funcionalidade', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $idFuncionalidade;

    #[ORM\Column(name: 'nome_funcde', type: 'string', length: 150, nullable: false)]
    private string $nomeFuncionalidade;


    #[ORM\Column(name: 'desc_funcde', type: 'string', length: 200, nullable: false)]
    private string $descFuncionalidade;

    #[ORM\Column(name: 'desc_url', type: 'string', length: 200, nullable: false)]
    private string $descUrl;

    /*
     * Getter and Setter
     */
    public function getIdFuncionalidade(): int
    {
        return $this->idFuncionalidade;
    }
    public function setIdFuncionalidade(int $val): void
    {
        $this->idFuncionalidade = $val;
    }
    public function getNomeFuncionalidade(): string
    {
        return $this->nomeFuncionalidade;
    }
    public function setNomeFuncionalidade(string $val): void
    {
        $this->nomeFuncionalidade = $val;
    }

    public function getDescFuncionalidade(): string
    {
        return $this->descFuncionalidade;
    }
    public function setDescFuncionalidade(string $val): void
    {
        $this->descFuncionalidade = $val;
    }

    public function getDescUrl(): string
    {
        return $this->descUrl;
    }
    public function setDescUrl(string $val): void
    {
        $this->descUrl = $val;
    }
}