<?php
declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class UsuarioRepository extends EntityRepository
{
  public function buscarUsuarios(){
    $qb = $this->createQueryBuilder('u');
    return $qb->getQuery()->getResult();

  }
}