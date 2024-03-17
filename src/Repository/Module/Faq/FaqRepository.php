<?php

namespace App\Repository\Module\Faq;

use App\Entity\Core\Website;
use App\Entity\Module\Faq\Faq;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * FaqRepository.
 *
 * @extends ServiceEntityRepository<Faq>
 *
 * @method Faq|null find($id, $lockMode = null, $lockVersion = null)
 * @method Faq|null findOneBy(array $criteria, array $orderBy = null)
 * @method Faq[]    findAll()
 * @method Faq[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @author Sébastien FOURNIER <contact@sebastien-fournier.com>
 */
class FaqRepository extends ServiceEntityRepository
{
    /**
     * FaqRepository constructor.
     */
    public function __construct(private readonly ManagerRegistry $registry)
    {
        parent::__construct($this->registry, Faq::class);
    }

    /**
     * Find one by filter.
     *
     * @throws NonUniqueResultException
     */
    public function findOneByFilter(Website $website, string $locale, mixed $filter): ?Faq
    {
        $queryBuilder = $this->createQueryBuilder('f')
            ->leftJoin('f.website', 'w')
            ->leftJoin('f.questions', 'q')
            ->leftJoin('q.i18ns', 'i')
            ->andWhere('f.website = :website')
            ->andWhere('i.locale = :locale')
            ->setParameter('website', $website)
            ->setParameter('locale', $locale)
            ->addSelect('w')
            ->addSelect('q')
            ->addSelect('i');

        if (is_numeric($filter)) {
            $queryBuilder->andWhere('f.id = :id')
                ->setParameter('id', $filter);
        } else {
            $queryBuilder->andWhere('f.slug = :slug')
                ->setParameter('slug', $filter);
        }

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * Find one by filter.
     *
     * @throws NonUniqueResultException
     */
    public function findOneByFilterPromote(Website $website, string $locale, mixed $filter): ?Faq
    {
        $queryBuilder = $this->createQueryBuilder('f')
            ->leftJoin('f.website', 'w')
            ->leftJoin('f.questions', 'q')
            ->leftJoin('q.i18ns', 'i')
            ->andWhere('f.website = :website')
            ->andWhere('q.promote = :promote')
            ->andWhere('i.locale = :locale')
            ->setParameter('website', $website)
            ->setParameter('promote', true)
            ->setParameter('locale', $locale)
            ->addSelect('w')
            ->addSelect('q')
            ->addSelect('i');

        if (is_numeric($filter)) {
            $queryBuilder->andWhere('f.id = :id')
                ->setParameter('id', $filter);
        } else {
            $queryBuilder->andWhere('f.slug = :slug')
                ->setParameter('slug', $filter);
        }

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}
