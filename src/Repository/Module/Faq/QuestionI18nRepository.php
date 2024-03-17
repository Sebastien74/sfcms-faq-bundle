<?php

namespace App\Repository\Module\Faq;

use App\Entity\Module\Faq\QuestionI18n;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * QuestionI18nRepository.
 *
 * @extends ServiceEntityRepository<QuestionI18n>
 *
 * @method QuestionI18n|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionI18n|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionI18n[]    findAll()
 * @method QuestionI18n[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @author Sébastien FOURNIER <contact@sebastien-fournier.com>
 */
class QuestionI18nRepository extends ServiceEntityRepository
{
    /**
     * FaqRepository constructor.
     */
    public function __construct(private readonly ManagerRegistry $registry)
    {
        parent::__construct($this->registry, QuestionI18nRepository::class);
    }
}
