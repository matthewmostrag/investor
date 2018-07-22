<?php

namespace Anaxago\CoreBundle\Controller;

use Anaxago\CoreBundle\Entity\Investment;
use Anaxago\CoreBundle\Entity\Project;
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
     * InvestController constructor.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Allow a user to invest in a project.
     */
    public function storeAction(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $investment = $this->createNewInvestment($request);

        $this->entityManager->persist($investment);
        $this->entityManager->flush();

        $this->addFlash('success', 'Votre investissement a bien été pris en compte, merci !');

        return $this->redirectToRoute('anaxago_core_homepage');
    }

    /**
     * Create a new investment instance from the request.
     */
    protected function createNewInvestment(Request $request): Investment
    {
        $user = $this->getUser();

        $projectId = $request->get('project_id');
        $project = $this->entityManager->getRepository(Project::class)->find($projectId);

        $investment = new Investment();
        $investment->setUser($user);
        $investment->setProject($project);
        $investment->setAmount($request->get('amount'));

        return $investment;
    }
}