<?php

namespace App\Repository;

use App\Entity\Bien;
use App\Entity\Search;
use App\Form\SearchType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bien|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bien|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bien[]    findAll()
 * @method Bien[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BienRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bien::class);
    }

    // /**
    //  * @return Bien[] Returns an array of Bien objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    public function FindBySearch(Search $search)
    {
        $query = $this->createQueryBuilder('a')
            ->innerJoin('a.proprietaire', 'u')
            ->addSelect('u')
            ->orderBy('a.created_at', 'DESC');

        if ($search->getSearchPrixMin()) {
            $query = $query->andWhere('a.prix >= :searchbienprixmin')
                ->setParameter('searchbienprixmin', $search->getSearchPrixMin());
        }

        if ($search->getSearchPrixMax()) {
            $query = $query->andWhere('a.prix <= :searchbienprixmax')
                ->setParameter('searchbienprixmax', $search->getSearchPrixMax());
        }

        if ($search->getSearchCategorie()) {
            $query = $query->andWhere('a.categorie = :searchbienCategorie')
                ->setParameter('searchbienCategorie', $search->getSearchCategorie());
        }

        if ($search->getSearchType()) {
            $query = $query->andWhere('a.type = :searchbienType')
                ->setParameter('searchbienType', $search->getSearchType());
        }
        if ($search->getSearchGlobal()) {
            $query = $query->andWhere('a.titre LIKE :searchsearchglobal')
                ->orWhere('a.description LIKE :searchsearchglobal')
                ->setParameter('searchsearchglobal', '%' . addcslashes($search->getSearchGlobal(), '%_') . '%');
        }

        return $query->getQuery();
    }

    public function findPaginateBiensPerso($userid)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.proprietaire = :userid')
            ->setParameter('userid', $userid)
            ->orderBy('a.created_at', 'ASC')
            ->getQuery();
    }

    public function findPaginateBiens()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.created_at', 'ASC')
            ->getQuery();
    }

    /*
    public function findOneBySomeField($value): ?Bien
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
