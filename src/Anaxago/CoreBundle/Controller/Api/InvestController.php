<?php

namespace Anaxago\CoreBundle\Controller\Api;

use Anaxago\CoreBundle\Entity\Project;
use Anaxago\CoreBundle\Service\InvestmentService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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
    public function storeAction(Request $request): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $data = json_decode($request->getContent(), true);

        if (!isset($data['project_id'])) {
            return new JsonResponse([
                'error' => "Can't find project_id"
            ], 400);
        }

        if (!isset($data['amount'])) {
            return new JsonResponse([
                'error' => "Can't find amount"
            ], 400);
        }

        $project = $this->entityManager->getRepository(Project::class)->find($data['project_id']);

        $amount = $data['amount'];

        if ($amount > $project->getRemainingAmount()) {
            return new JsonResponse([
                'error' => "Can't invest more than {$project->getRemainingAmount()} in project {$project->getTitle()}."
            ], 422);
        }

        $this->investmentService->saveNewInvestment($this->getUser(), $project, $amount);

        return new JsonResponse("{$amount} € invested successfully in project {$project->getTitle()}");
    }
}