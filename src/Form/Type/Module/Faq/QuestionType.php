<?php

namespace App\Form\Type\Module\Faq;

use App\Entity\Module\Faq\Question;
use App\Form\Widget as WidgetType;
use App\Service\Interface\CoreLocatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * QuestionType.
 *
 * @author Sébastien FOURNIER <contact@sebastien-fournier.com>
 */
class QuestionType extends AbstractType
{
    private TranslatorInterface $translator;
    private EntityManagerInterface $entityManager;

    /**
     * QuestionType constructor.
     */
    public function __construct(private readonly CoreLocatorInterface $coreLocator)
    {
        $this->translator = $this->coreLocator->translator();
        $this->entityManager = $this->coreLocator->em();
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isNew = !$builder->getData()->getId();

        $adminName = new WidgetType\AdminNameType($this->coreLocator);
        $adminName->add($builder);

        if (!$isNew) {
            $mediaRelations = new WidgetType\MediaRelationsCollectionType($this->coreLocator);
            $mediaRelations->add($builder, [
                'data_config' => true,
                'entry_options' => ['onlyMedia' => true],
            ]);

            $i18ns = new WidgetType\i18nsCollectionType($this->coreLocator);
            $i18ns->add($builder, [
                'fields' => ['title', 'introduction', 'body'],
                'label_fields' => [
                    'title' => $this->translator->trans('Question', [], 'admin'),
                    'body' => $this->translator->trans('Réponse', [], 'admin'),
                ],
            ]);
        }

        $save = new WidgetType\SubmitType($this->coreLocator);
        $save->add($builder, ['btn_both' => true]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
            'website' => null,
            'translation_domain' => 'admin',
        ]);
    }
}
