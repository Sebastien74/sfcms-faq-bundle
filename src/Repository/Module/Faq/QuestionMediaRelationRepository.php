<?php

namespace App\Repository\Module\Faq;

use App\Entity\Module\Faq\QuestionMediaRelation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * QuestionMediaRelationRepository.
 *
 * @extends ServiceEntityRepository<QuestionMediaRelation>
 *
 * @method QuestionMediaRelation|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionMediaRelation|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionMediaRelation[]    findAll()
 * @method QuestionMediaRelation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @author Sébastien FOURNIER <contact@sebastien-fournier.com>
 */
class QuestionMediaRelationRepository extends ServiceEntityRepository
{
    /**
     * QuestionMediaRelationRepository constructor.
     */
    public function __construct(private readonly ManagerRegistry $registry)
    {
        parent::__construct($this->registry, QuestionMediaRelationRepository::class);
    }
}
