<?php

namespace App\Repository;

use App\Entity\Movimentacao;
use App\Model\SituacaoInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Movimentacao|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movimentacao|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movimentacao[]    findAll()
 * @method Movimentacao[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovimentacaoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Movimentacao::class);
    }

   /**
    * @return Movimentacao[] Returns an array of Movimentacao objects
    */
    public function encontrarPorFuncionario(int $funcionarioId)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.funcionario = :funcionario AND m.situacao = :situacao')
            ->setParameters([
                'funcionario' => $funcionarioId,
                'situacao' => SituacaoInterface::SITUACAO_ATIVO
            ])
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Movimentacao
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
