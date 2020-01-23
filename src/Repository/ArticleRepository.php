<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }


//łatwiejszy sposób ale robi to samo co niżej

//    public function findAllPublishedOrderByNewest()
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.publishedAt IS NOT NULL')
//            ->orderBy('a.publishedAt','DESC')
//            ->getQuery()
//            ->getResult();
//    }


    /**
     * @return Article[]
     */

    public function findAllPublishedOrderByNewest()
    {
        return $this->addIsPublishedQueryBuilder()
            ->orderBy('a.publishedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }


    /**
     * wybiera i wyświetla tylko komentarze które nie maja statusu false (nie są usunięte), przekazanie funkcji do encji Article a na nasępnie do widoku article/show
     * lepsza opcja niż sprawdzanie w kontrolerze za pomoca pętli gdy jest dużo danych
     * create = polecenie mówiące utwórz kryteriu do filtrowania/wyszukiwania
     * expr = expression czyli wyrażenie daje znać że będzie to zapytanie na podsawie kryteriów
     * eq = equals tj kolumna i wartość na podstawie których ma zwracać wartości
     **/
    public static function createNonDeletedCriteria(): Criteria
    {
        return Criteria::create()
            ->andWhere(Criteria::expr()->eq('isDeleted', false))
            ->orderBy(['createdAt' => 'DESC']);
    }

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    private function addIsPublishedQueryBuilder(QueryBuilder $queryBuilder = null)
    {
        return $this->getOrCreateQueryBuilder($queryBuilder)
            ->andWhere('a.publishedAt IS NOT NULL');
    }

    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null)
    {
        return $queryBuilder ?: $this->createQueryBuilder('a');
    }
}
