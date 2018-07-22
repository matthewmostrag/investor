<?php

namespace Anaxago\CoreBundle\Controller\Api;

use Anaxago\CoreBundle\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProjectController extends Controller
{
    /**
     * List all the projects.
     */
    public function indexAction(EntityManagerInterface $entityManager): JsonResponse
    {
        $projects = $entityManager->getRepository(Project::class)->findAll();

        $formattedProjects = [];

        foreach ($projects as $project) {
            $formattedProjects[] = [
                'id' => $project->getId(),
                'title' => $project->getTitle(),
                'description' => $project->getDescription(),
                'fundingLimit' => $project->getFundingLimit(),
                'investedAmount' => $project->getInvestedAmount(),
                'progressPercentage' => $project->getProgress(),
                'funded' => $project->isFunded()
            ];
        }

        return new JsonResponse($formattedProjects);
    }
}