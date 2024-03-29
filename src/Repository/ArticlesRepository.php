<?php

namespace App\Repository;

use App\Entity\Articles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Articles>
 *
 * @method Articles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Articles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Articles[]    findAll()
 * @method Articles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticlesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Articles::class);
    }

    public function save(Articles $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Articles $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Articles[] Returns an array of Articles objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    /**
     * Ceci est la methode qui nous renvoie 3 articles liés à un article
     */

    public function findLastThreeRelatedArticles($idCategory, $idArticle) {

        return $this->createQueryBuilder('a')
        ->where('a.category = :idCategory')
        ->setParameter('idCategory', $idCategory)
        ->andWhere('a.id <> :idArticle')
        ->setParameter('idArticle', $idArticle)
        ->orderBy('a.date', 'DESC')
        ->setMaxResults(3)
        ->getQuery()
        ->getResult();

    }

    public function findBySearch($search) {

        return $this->createQueryBuilder('a')
        ->where('a.description LIKE :search')
        ->setParameter('search', '%' . $search . '%')
        ->setMaxResults(10)
        ->getQuery()
        ->getResult();

    }

//    public function findOneBySomeField($value): ?Articles
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
