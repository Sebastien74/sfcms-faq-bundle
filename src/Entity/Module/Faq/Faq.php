<?php

namespace App\Entity\Module\Faq;

use App\Entity\BaseEntity;
use App\Entity\Core\Website;
use App\Entity\Translation\i18n;
use App\Repository\Module\Faq\FaqRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Faq.
 *
 * @author Sébastien FOURNIER <contact@sebastien-fournier.com>
 */
#[ORM\Table(name: 'module_faq')]
#[ORM\Entity(repositoryClass: FaqRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Faq extends BaseEntity
{
    /**
     * Configurations.
     */
    protected static string $masterField = 'website';
    protected static array $interface = [
        'name' => 'faq',
        'search' => true,
        'buttons' => [
            'questions' => 'admin_faqquestion_index',
        ],
    ];
    protected static array $labels = [
        'admin_faqquestion_index' => 'Questions',
    ];

    #[ORM\OneToMany(mappedBy: 'faq', targetEntity: Question::class, orphanRemoval: true)]
    private ArrayCollection|PersistentCollection $questions;

    #[ORM\ManyToOne(targetEntity: Website::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Website $website = null;

    #[ORM\OneToMany(mappedBy: 'faq', targetEntity: FaqI18n::class, cascade: ['persist'], orphanRemoval: true)]
    #[ORM\JoinColumn(onDelete: 'cascade')]
    #[ORM\OrderBy(['locale' => 'ASC'])]
    #[Assert\Valid]
    private ArrayCollection|PersistentCollection $i18ns;

    /**
     * Faq constructor.
     */
    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->i18ns = new ArrayCollection();
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setFaq($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getFaq() === $this) {
                $question->setFaq(null);
            }
        }

        return $this;
    }

    public function getWebsite(): ?Website
    {
        return $this->website;
    }

    public function setWebsite(?Website $website): self
    {
        $this->website = $website;

        return $this;
    }

    /**
     * @return Collection<int, FaqI18n>
     */
    public function getI18ns(): Collection
    {
        return $this->i18ns;
    }

    public function addI18n(FaqI18n $i18n): static
    {
        if (!$this->i18ns->contains($i18n)) {
            $this->i18ns->add($i18n);
            $i18n->setFaq($this);
        }

        return $this;
    }

    public function removeI18n(FaqI18n $i18n): static
    {
        if ($this->i18ns->removeElement($i18n)) {
            // set the owning side to null (unless already changed)
            if ($i18n->getFaq() === $this) {
                $i18n->setFaq(null);
            }
        }

        return $this;
    }
}
