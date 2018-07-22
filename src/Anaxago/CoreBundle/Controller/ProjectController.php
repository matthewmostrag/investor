<?php

namespace Anaxago\CoreBundle\Controller;
use Anaxago\CoreBundle\Entity\Project;
use Anaxago\CoreBundle\Form\Type\ProjectType;
use Anaxago\CoreBundle\Service\UploadService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\File;
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
     * The EntityManager instance.
     *
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * ProjectController constructor.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Allow a admin to add a new project.
     */
    public function createAction(Request $request, UploadService $uploadService): Response
    {
        $project = new Project();

        $form = $this->createForm(ProjectType::class, $project);
        $form->add('save', SubmitType::class, [
            'label' => 'Ajouter le projet',
            'attr' => ['class' => 'btn btn-success']
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $project->getCover();
            $path = $uploadService->upload($file);
            $project->setCover($path);

            $this->entityManager->persist($project);
            $this->entityManager->flush();

            return $this->redirectToRoute('anaxago_core_admin_index');
        }

        return $this->render('@AnaxagoCore/Admin/Project/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Allow and admin to edit an existing project.
     */
    public function editAction(Project $project, Request $request, UploadService $uploadService): Response
    {
        // Convert the file stored path to a File instance for Symfony form.
        $project->setCover(new File(
            $this->getParameter('upload_directory') . '/' . $project->getCover()
        ));

        $form = $this->createForm(ProjectType::class, $project);
        $form->add('save', SubmitType::class, [
            'label' => 'Modifier le projet',
            'attr' => ['class' => 'btn btn-success']
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $project->getCover();
            $path = $uploadService->upload($file);
            $project->setCover($path);

            $this->entityManager->persist($project);
            $this->entityManager->flush();

            return $this->redirectToRoute('anaxago_core_admin_index');
        }

        return $this->render('@AnaxagoCore/Admin/Project/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Archive the given project.
     */
    public function destroyAction(Project $project): Response
    {
        $project->archive();

        $this->entityManager->persist($project);
        $this->entityManager->flush();

        $this->addFlash('info', "Le projet {$project->getTitle()} a bien été supprimé !");

        return $this->redirectToRoute('anaxago_core_admin_index');
    }
}