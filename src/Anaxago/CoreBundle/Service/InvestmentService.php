<?php

namespace Anaxago\CoreBundle\Service;

use Anaxago\CoreBundle\Entity\Investment;
use Anaxago\CoreBundle\Entity\Project;
use Anaxago\CoreBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class InvestmentService
{
    /**
     * The EntityManager instance.
     *
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * The Mailer instance.
     *
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * InvestmentService constructor.
     */
    public function __construct(EntityManagerInterface $entityManager, \Swift_Mailer $mailer)
    {
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
    }

    /**
     * Create and save a new investment for the given project.
     */
    public function saveNewInvestment(User $user, Project $project, int $amount): void
    {
        $investment = new Investment();
        $investment->setUser($user);
        $investment->setProject($project);
        $investment->setAmount($amount);

        $this->entityManager->persist($investment);
        $this->entityManager->flush();

        // Refresh the project to be sure to have all investments
        $this->entityManager->refresh($project);

        if ($project->isFunded()) {
            $this->alertInvestors($project);
        }
    }

    /**
     * Send an email to all project investors to alert them that it has been funded.
     */
    private function alertInvestors(Project $project): void
    {
        $investorsAddresses = [];

        /** @var Investment $investment */
        foreach ($project->getInvestments() as $investment) {
            $investorsAddresses[] = $investment->getUser()->getEmail();
        }

        $message = (new \Swift_Message('Projet financé !'))
            ->setFrom('houra@investor.app')
            ->setTo($investorsAddresses)
            ->setBody("Le projet {$project->getTitle()} a été entièrement financé !");

        $this->mailer->send($message);
    }
}