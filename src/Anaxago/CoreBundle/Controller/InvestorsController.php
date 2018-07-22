<?php

namespace Anaxago\CoreBundle\Controller;

use Anaxago\CoreBundle\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class InvestorsController extends Controller
{
    /**
     * Show a list of the given project investors.
     */
    public function indexAction(Project $project): Response
    {
        return $this->render('@AnaxagoCore/Admin/Investors/index.html.twig', [
            'project' => $project
        ]);
    }
}