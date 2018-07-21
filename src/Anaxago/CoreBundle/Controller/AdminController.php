<?php declare(strict_types = 1);

namespace Anaxago\CoreBundle\Controller;

use Anaxago\CoreBundle\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AdminController
 *
 * @package Anaxago\CoreBundle\Controller
 */
class AdminController extends Controller
{
    /**
     * Display the projects list to admin users.
     */
    public function indexAction(EntityManagerInterface $entityManager): Response
    {
        $projects = $entityManager->getRepository(Project::class)->findAll();

        return $this->render('@AnaxagoCore/Admin/index.html.twig', ['projects' => $projects]);
    }
}