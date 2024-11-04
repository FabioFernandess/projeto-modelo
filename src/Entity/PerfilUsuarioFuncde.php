<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[ORM\Table(name: 'perfil_usuario_funcde')]
#[ORM\Entity(repositoryClass: 'App\Repository\PerfilUsuarioFuncdeRepository')]
final class PerfilUsuarioFuncde
{
    #[ORM\Column(name: 'id_perfil_usuario_funcde', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $idPerfilUsuarioFuncde;

    #[ManyToOne(targetEntity: FuncdeOperacaoSistema::class)]
    #[JoinColumn(name: 'id_funcde_operacao_sistema', referencedColumnName: 'id_funcde_operacao_sistema')]
    private FuncdeOperacaoSistema|null $funcdeOperacaoSistema = null;


    #[ManyToOne(targetEntity: PerfilUsuario::class)]
    #[JoinColumn(name: 'id_perfil_usuario', referencedColumnName: 'id_perfil_usuario')]
    private PerfilUsuario|null $perfilUsuario = null;



    public function getIdPerfilUsuarioFuncde(): int
    {
        return $this->idPerfilUsuarioFuncde;
    }
    public function setIdPerfilUsuarioFuncde(int $val): void
    {
        $this->idPerfilUsuarioFuncde = $val;
    }

    public function getFuncdeOperacaoSistema(): FuncdeOperacaoSistema
    {
        return $this->funcdeOperacaoSistema;
    }
    public function setFuncdeOperacaoSistema(FuncdeOperacaoSistema $val): void
    {
        $this->funcdeOperacaoSistema = $val;
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