<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[ORM\Table(name: 'funcde_operacao_sistema')]
#[ORM\Entity(repositoryClass: 'App\Repository\FuncdeOperacaoSistemaRepository')]
final class FuncdeOperacaoSistema
{
    #[ORM\Column(name: 'id_funcde_operacao_sistema', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $idFuncdeOperacaoSistema;

    #[ManyToOne(targetEntity: Funcionalidade::class)]
    #[JoinColumn(name: 'id_funcionalidade', referencedColumnName: 'id_funcionalidade')]
    private Funcionalidade|null $funcionalidade = null;


    #[ManyToOne(targetEntity: OperacaoSistema::class)]
    #[JoinColumn(name: 'id_operacao_sistema', referencedColumnName: 'id_operacao_sistema')]
    private OperacaoSistema|null $operacaoSistema = null;



    public function getIdFuncdeOperacaoSistema(): int
    {
        return $this->idFuncdeOperacaoSistema;
    }
    public function setIdFuncdeOperacaoSistema(int $val): void
    {
        $this->idFuncdeOperacaoSistema = $val;
    }

    public function getFuncionalidade(): Funcionalidade
    {
        return $this->funcionalidade;
    }
    public function setFuncionalidade(Funcionalidade $val): void
    {
        $this->funcionalidade = $val;
    }
    public function getOperacaoSistema(): OperacaoSistema
    {
        return $this->operacaoSistema;
    }
    public function setOperacaoSistema(OperacaoSistema $val): void
    {
        $this->operacaoSistema = $val;
    }

}