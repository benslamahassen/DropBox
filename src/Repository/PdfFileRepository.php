<?php

namespace App\Repository;

use App\Entity\PdfFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PdfFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method PdfFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method PdfFile[]    findAll()
 * @method PdfFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PdfFileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PdfFile::class);
    }

    // /**
    //  * @return File[] Returns an array of File objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?File
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
