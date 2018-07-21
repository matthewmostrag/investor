<?php

namespace Anaxago\CoreBundle\Controller;
use Anaxago\CoreBundle\Entity\Project;
use Anaxago\CoreBundle\Form\Type\ProjectType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ProjectController
 *
 * @package Anaxago\CoreBundle\Controller
 */
class ProjectController extends Controller
{
    /**
     * Allow a admin to add a new project.
     */
    public function createAction(Request $request, EntityManagerInterface $entityManager): Response
    {
        $project = new Project();

        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($project);
            $entityManager->flush();

            return $this->redirectToRoute('anaxago_core_admin_index');
        }

        return $this->render('@AnaxagoCore/Admin/Project/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}