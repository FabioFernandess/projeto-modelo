<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\FuncdeOperacaoSistema;
use App\Entity\Funcionalidade;
use App\Entity\OperacaoSistema;
use App\Entity\PerfilUsuario;
use App\Entity\UsuarioPerfil;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class PerfilUsuarioFuncdeRepository extends EntityRepository
{
    public function permissaoFuncionalidade($container, $idFuncde = null, $idUsuario = null, $menu = true, $idUnidade = null, $idPerfil = null)
    {
        $retorno['operacao'] = [];
        $retorno['funcionalidade'] = [];
        $qb = $this->createQueryBuilder('puf')->select('os.nomeOperacao, f.idFuncionalidade, f.descUrl');
        $qb->join(PerfilUsuario::class, 'pu', Join::WITH, "pu.idPerfilUsuario = puf.perfilUsuario and pu.statPerfil = 'A'");
        $qb->join(UsuarioPerfil::class, 'puu', Join::WITH, "puu.perfilUsuario = pu.idPerfilUsuario");
        $qb->join(FuncdeOperacaoSistema::class, 'fos', Join::WITH, "fos.idFuncdeOperacaoSistema = puf.funcdeOperacaoSistema");
        $qb->join(OperacaoSistema::class, 'os', Join::WITH, "os.idOperacaoSistema = fos.operacaoSistema");
        $qb->join(Funcionalidade::class, 'f', Join::WITH, "f.idFuncionalidade = fos.funcionalidade");

        if ($idFuncde != null) {
            $qb->andWhere("fos.funcionalidade = :idFuncde");
            $qb->setParameter('idFuncde', $idFuncde);
        }

        if ($idUnidade != null) {
            $qb->andWhere("puu.unidade = :idUnidade or puu.unidade is null");
            $qb->setParameter('idUnidade', $idUnidade);
        }
        if ($idPerfil != null) {
            $qb->andWhere("puu.perfilUsuario = :idPerfil");
            $qb->setParameter('idPerfil', $idPerfil);
        }

        if ($idUsuario != null) {
            $qb->andWhere("puu.usuario = :idUsuario");
            $qb->setParameter('idUsuario', $idUsuario);
        }

        $resultado = $qb->getQuery()->getResult();
       
        if (count($resultado) > 0) {
            foreach ($resultado as $res) {
                $retorno['operacao'][] = mb_strtolower($res['nomeOperacao']);
                if ($menu == true) {
                    if (
                        $res['nomeOperacao'] == 'Consultar'  ||
                        $res['nomeOperacao'] == 'Atender' ||
                        ($res['nomeOperacao'] == 'Alterar' && $res['idFuncionalidade'] == 67) ||
                        ($res['nomeOperacao'] == 'Incluir' && $res['idFuncionalidade'] == 68)
                    ) {
                        $retorno['funcionalidade'][] = [
                            'idFuncionalidade' => $res['idFuncionalidade'],
                            'operacao' => mb_strtolower($res['nomeOperacao']),
                            'descUrl' => $res['descUrl']
                        ];
                    }
                } else {
                    $retorno['funcionalidade'][] = [
                        'idFuncionalidade' => $res['idFuncionalidade'],
                        'operacao' => mb_strtolower($res['nomeOperacao']),
                        'descUrl' => $res['descUrl']
                    ];
                }
            }
        }
        return $retorno;
    }
}
