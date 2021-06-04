<?php

namespace App\Repository;

use App\Entity\Post;
use App\Entity\SearchData;
use App\Entity\SearchPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }
    public function getSearchQuery(SearchData $search)
    {

        $query = $this->createQueryBuilder('p');


       if (!empty($search->city)) {
            $query = $query
                ->select('p')
                ->andWhere('p.city =:city')
                ->setParameter('city', $search->city);
        }
        if (!empty($search->postTypes)) {
            $query = $query
                ->select('p')
                ->andwhere('p.type =:type')
                ->setParameter('type', $search->postTypes);
        }
        if (!empty($search->postTypes && $search->city)) {
            $query = $query
                ->select('p')
                ->andWhere('p.type =:type')
                ->andWhere('p.city =:city')
                ->setParameter('type', $search->postTypes)
                ->setParameter('city', $search->city);
            ;
        }


        return $query->getQuery()->getResult();

    }
    public function findSearch(SearchData $search)
    {
        return $this->getSearchQuery($search);
    }

    public function findAllVisibleQuery(SearchPost $search)
    {
        $query = $this->createQueryBuilder('p')->select('p');

        if(!empty($search->getCity())){
           /* $k =0;
            foreach ($search->getCity() as $k => $city){
                $k++;
                $query = $query
                    ->andWhere(":city$k MEMBER OF p.city")
                    ->setParameter("city$k", $city);
            }*/
          //  $query = $query->where()
             $query= $query->andWhere('p.city=:city')
                ->setParameter('city', $search->getCity())

            ;
        }


        return $query->select('p')->getQuery()->getResult();

    }
    private function findVisibleQuery() : QueryBuilder
    {
        return $this->createQueryBuilder('p');
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
