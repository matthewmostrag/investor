<?php

namespace Anaxago\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Investment
 *
 * @ORM\Table(name="investment")
 * @ORM\Entity(repositoryClass="Anaxago\CoreBundle\Repository\InvestmentRepository")
 */
class Investment
{
    /**
     * The id.
     *
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * The amount invested.
     *
     * @var int
     *
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

    /**
     * The project linked to the investement.
     *
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="Anaxago\CoreBundle\Entity\Project")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    /**
     * The user who invested.
     *
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Anaxago\CoreBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * Get the id.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the invested amount.
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * Set the invested amount.
     */
    public function setAmount(int $amount): Investment
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the project linked to the investment.
     */
    public function getProject(): Project
    {
        return $this->project;
    }

    /**
     * Set the project to invest in.
     */
    public function setProject(Project $project): Investment
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get the user who invested.
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * Set the user who invested.
     */
    public function setUser(User $user): Investment
    {
        $this->user = $user;

        return $this;
    }
}