<?php

namespace App\Controller\Front\Action;

use App\Controller\Front\FrontController;
use App\Entity\Core\Website;
use App\Entity\Layout\Block;
use App\Entity\Module\Faq\Faq;
use App\Entity\Module\Faq\Question;
use App\Repository\Module\Faq\FaqRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * FaqController.
 *
 * Front Faq renders
 *
 * @author Sébastien FOURNIER <contact@sebastien-fournier.com>
 */
class FaqController extends FrontController
{
    /**
     * View.
     *
     * @throws NonUniqueResultException
     */
    #[Route('/front/faq/view/{filter}', name: 'front_faq_view', options: ['isMainRequest' => false], methods: 'GET', schemes: '%protocol%')]
    public function view(Request $request, FaqRepository $faqRepository, Website $website, ?Block $block = null, mixed $filter = null): Response
    {
        if (!$filter) {
            return new Response();
        }

        /** @var Faq $faq */
        $faq = $faqRepository->findOneByFilter($website, $request->getLocale(), $filter);

        if (!$faq) {
            return new Response();
        }

        $configuration = $website->getConfiguration();
        $websiteTemplate = $configuration->getTemplate();
        $entity = $block instanceof Block ? $block : $faq;
        $entity->setUpdatedAt($faq->getUpdatedAt());

        return $this->render('front/'.$websiteTemplate.'/actions/faq/view.html.twig', [
            'configuration' => $configuration,
            'websiteTemplate' => $websiteTemplate,
            'website' => $website,
            'thumbConfiguration' => $this->thumbConfiguration($website, Question::class, 'view'),
            'faq' => $faq,
        ]);
    }

    /**
     * View.
     *
     * @throws NonUniqueResultException
     */
    #[Route('/front/faq/teaser/{filter}', name: 'front_faq_teaser', options: ['isMainRequest' => false], methods: 'GET', schemes: '%protocol%')]
    public function teaser(Request $request, FaqRepository $faqRepository, Website $website, ?Block $block = null, mixed $filter = null): Response
    {
        if (!$filter) {
            return new Response();
        }

        /** @var Faq $faq */
        $faq = $faqRepository->findOneByFilterPromote($website, $request->getLocale(), $filter);

        if (!$faq) {
            return new Response();
        }

        $configuration = $website->getConfiguration();
        $websiteTemplate = $configuration->getTemplate();
        $entity = $block instanceof Block ? $block : $faq;
        $entity->setUpdatedAt($faq->getUpdatedAt());

        return $this->render('front/'.$websiteTemplate.'/actions/faq/view.html.twig', [
            'configuration' => $configuration,
            'websiteTemplate' => $websiteTemplate,
            'website' => $website,
            'thumbConfiguration' => $this->thumbConfiguration($website, Question::class, 'view'),
            'faq' => $faq,
        ]);
    }
}
