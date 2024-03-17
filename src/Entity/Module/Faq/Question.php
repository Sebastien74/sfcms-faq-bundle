<?php

namespace App\Entity\Module\Faq;

use App\Entity\BaseEntity;
use App\Entity\Media\MediaRelation;
use App\Entity\Translation\i18n;
use App\Repository\Module\Faq\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Question.
 *
 * @author Sébastien FOURNIER <contact@sebastien-fournier.com>
 */
#[ORM\Table(name: 'module_faq_question')]
#[ORM\Entity(repositoryClass: QuestionRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Question extends BaseEntity
{
    /**
     * Configurations.
     */
    protected static string $masterField = 'faq';
    protected static array $interface = [
        'name' => 'faqquestion',
        'search' => true,
    ];

    #[ORM\Column(type: 'boolean')]
    private bool $promote = false;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: QuestionI18n::class, cascade: ['persist'], orphanRemoval: true)]
    #[ORM\JoinColumn(onDelete: 'cascade')]
    #[ORM\OrderBy(['locale' => 'ASC'])]
    #[Assert\Valid]
    private ArrayCollection|PersistentCollection $i18ns;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: QuestionMediaRelation::class, cascade: ['persist'], orphanRemoval: true)]
    #[ORM\JoinColumn(onDelete: 'cascade')]
    #[ORM\OrderBy(['locale' => 'ASC'])]
    #[Assert\Valid]
    private ArrayCollection|PersistentCollection $mediaRelations;

    #[ORM\ManyToOne(targetEntity: Faq::class, inversedBy: 'questions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Faq $faq = null;

    /**
     * Question constructor.
     */
    public function __construct()
    {
        $this->i18ns = new ArrayCollection();
        $this->mediaRelations = new ArrayCollection();
    }

    public function isPromote(): ?bool
    {
        return $this->promote;
    }

    public function setPromote(bool $promote): self
    {
        $this->promote = $promote;

        return $this;
    }

    /**
     * @return Collection<int, QuestionI18n>
     */
    public function getI18ns(): Collection
    {
        return $this->i18ns;
    }

    public function addI18n(QuestionI18n $i18n): static
    {
        if (!$this->i18ns->contains($i18n)) {
            $this->i18ns->add($i18n);
            $i18n->setQuestion($this);
        }

        return $this;
    }

    public function removeI18n(QuestionI18n $i18n): static
    {
        if ($this->i18ns->removeElement($i18n)) {
            // set the owning side to null (unless already changed)
            if ($i18n->getQuestion() === $this) {
                $i18n->setQuestion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, QuestionMediaRelation>
     */
    public function getMediaRelations(): Collection
    {
        return $this->mediaRelations;
    }

    public function addMediaRelation(QuestionMediaRelation $mediaRelation): static
    {
        if (!$this->mediaRelations->contains($mediaRelation)) {
            $this->mediaRelations->add($mediaRelation);
            $mediaRelation->setQuestion($this);
        }

        return $this;
    }

    public function removeMediaRelation(QuestionMediaRelation $mediaRelation): static
    {
        if ($this->mediaRelations->removeElement($mediaRelation)) {
            // set the owning side to null (unless already changed)
            if ($mediaRelation->getQuestion() === $this) {
                $mediaRelation->setQuestion(null);
            }
        }

        return $this;
    }

    public function getFaq(): ?Faq
    {
        return $this->faq;
    }

    public function setFaq(?Faq $faq): self
    {
        $this->faq = $faq;

        return $this;
    }
}
