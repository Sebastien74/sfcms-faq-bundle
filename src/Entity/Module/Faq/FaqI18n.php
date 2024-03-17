<?php

namespace App\Entity\Module\Faq;

use App\Entity\BaseI18n;
use App\Repository\Module\Faq\FaqI18nRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * FaqI18n.
 *
 * @author Sébastien FOURNIER <contact@sebastien-fournier.com>
 */
#[ORM\Table(name: 'module_faq_i18ns')]
#[ORM\Entity(repositoryClass: FaqI18nRepository::class)]
class FaqI18n extends BaseI18n
{
    #[ORM\ManyToOne(targetEntity: Faq::class, cascade: ['persist'], inversedBy: 'i18ns')]
    #[ORM\JoinColumn(onDelete: 'cascade')]
    private ?Faq $faq = null;

    public function getFaq(): ?Faq
    {
        return $this->faq;
    }

    public function setFaq(?Faq $faq): static
    {
        $this->faq = $faq;

        return $this;
    }
}
