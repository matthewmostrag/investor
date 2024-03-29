<?php

namespace Anaxago\CoreBundle\Controller;

use Anaxago\CoreBundle\Entity\Project;
use Anaxago\CoreBundle\Service\InvestmentService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InvestController extends Controller
{
    /**
     * The EntityManager instance.
     *
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * Service used to manage investments.
     *
     * @var InvestmentService
     */
    private $investmentService;

    /**
     * InvestController constructor.
     */
    public function __construct(EntityManagerInterface $entityManager, InvestmentService $investmentService)
    {
        $this->entityManager = $entityManager;
        $this->investmentService = $investmentService;
    }

    /**
     * Allow a user to invest in a project.
     */
    public function storeAction(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $projectId = $request->get('project_id');
        $project = $this->entityManager->getRepository(Project::class)->find($projectId);

        $amount = $request->request->get('amount');

        if ($amount > $project->getRemainingAmount()) {
            $this->addFlash('danger', "Vous ne pouvez pas investir plus de {$project->getRemainingAmount()} dans le projet {$project->getTitle()} !");

            return $this->redirectToRoute('anaxago_core_homepage');
        }

        $this->investmentService->saveNewInvestment($this->getUser(), $project, $amount);

        $this->addFlash('success', 'Votre investissement a bien été pris en compte, merci !');

        return $this->redirectToRoute('anaxago_core_homepage');
    }
}