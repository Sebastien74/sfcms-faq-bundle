<?php

namespace App\Entity\Module\Faq;

use App\Entity\BaseI18n;
use App\Repository\Module\Faq\QuestionI18nRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * QuestionI18n.
 *
 * @author Sébastien FOURNIER <contact@sebastien-fournier.com>
 */
#[ORM\Table(name: 'module_faq_question_i18ns')]
#[ORM\Entity(repositoryClass: QuestionI18nRepository::class)]
class QuestionI18n extends BaseI18n
{
    #[ORM\ManyToOne(targetEntity: Question::class, cascade: ['persist'], inversedBy: 'i18ns')]
    #[ORM\JoinColumn(onDelete: 'cascade')]
    private ?Question $question = null;

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): static
    {
        $this->question = $question;

        return $this;
    }
}
