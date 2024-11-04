<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'operacao_sistema')]
#[ORM\Entity(repositoryClass: 'App\Repository\OperacaoSistemaRepository')]
final class OperacaoSistema
{
    #[ORM\Column(name: 'id_operacao_sistema', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $idOperacaoSistema;

    #[ORM\Column(name: 'nome_operacao', type: 'string', length: 150, nullable: false)]
    private string $nomeOperacao;


    #[ORM\Column(name: 'desc_operacao', type: 'string', length: 500, nullable: false)]
    private string $descOperacao;

    /*
     * Getter and Setter
     */
    public function getIdOperacaoSistema(): int
    {
        return $this->idOperacaoSistema;
    }
    public function setIdOperacaoSistema(int $val): void
    {
        $this->idOperacaoSistema = $val;
    }
    public function getNomeOperacao(): string
    {
        return $this->nomeOperacao;
    }
    public function setNomeOperacao(string $val): void
    {
        $this->nomeOperacao = $val;
    }

    public function getDescOperacao(): string
    {
        return $this->descOperacao;
    }
    public function setDescOperacao(string $val): void
    {
        $this->descOperacao = $val;
    }

}