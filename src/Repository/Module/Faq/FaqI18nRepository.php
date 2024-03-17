<?php

namespace App\Repository\Module\Faq;

use App\Entity\Module\Faq\FaqI18n;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FaqI18n>
 *
 * @method FaqI18n|null find($id, $lockMode = null, $lockVersion = null)
 * @method FaqI18n|null findOneBy(array $criteria, array $orderBy = null)
 * @method FaqI18n[]    findAll()
 * @method FaqI18n[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @author Sébastien FOURNIER <contact@sebastien-fournier.com>
 */
class FaqI18nRepository extends ServiceEntityRepository
{
    /**
     * FaqI18nRepository constructor.
     */
    public function __construct(private readonly ManagerRegistry $registry)
    {
        parent::__construct($this->registry, FaqI18n::class);
    }
}
