<?php

namespace Anaxago\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Project
 *
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="Anaxago\CoreBundle\Repository\ProjectRepository")
 */
class Project
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     *
     * @Assert\NotBlank()
     * @Assert\Regex("/^[a-z0-9]+(?:-[a-z0-9]+)*$/")
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min=3, minMessage="Le titre doit contenir au moins 3 caractères")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     *
     * @Assert\NotBlank()
     * @Assert\Length(min=10, minMessage="La description doit contenir au moins 10 caractères")
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="archived", type="boolean")
     */
    private $archived = false;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     * @Assert\Image()
     */
    private $cover;

    /**
     * @var int
     *
     * @ORM\Column(name="funding_limit", type="integer")
     *
     * @Assert\Range(min=0)
     */
    private $fundingLimit;

    /**
     * @var PersistentCollection
     *
     * @ORM\OneToMany(targetEntity="Anaxago\CoreBundle\Entity\Investment", mappedBy="project")
     */
    private $investments;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Project
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Project
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Project
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the project archived status.
     *
     * @return Project
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;

        return $this;
    }

    /**
     * Archive the project
     *
     * @return Project
     */
    public function archive()
    {
        $this->archived = true;

        return $this;
    }

    /**
     * Is the project archived?
     *
     * @return boolean
     */
    public function isArchived()
    {
        return $this->archived;
    }

    /**
     * Set the cover.
     *
     * @return Project
     */
    public function setCover($cover)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * Get the cover.
     *
     * @return string
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * Set the funding limit.
     *
     * @return Project
     */
    public function setFundingLimit($fundingLimit)
    {
        $this->fundingLimit = $fundingLimit;
    }

    /**
     * Get the funding limit.
     *
     * @return int
     */
    public function getFundingLimit()
    {
        return $this->fundingLimit;
    }

    /**
     * Get all investments on this project.
     */
    public function getInvestments(): PersistentCollection
    {
        return $this->investments;
    }

    /**
     * Get the amount invested in the project.
     */
    public function getInvestedAmount(): int
    {
        $investedAmount = 0;

        foreach ($this->investments as $investment) {
            $investedAmount += $investment->getAmount();
        }

        return $investedAmount;
    }

    /**
     * What's the remaining amount for the project to be funded?
     */
    public function getRemainingAmount(): int
    {
        return $this->fundingLimit - $this->getInvestedAmount();
    }

    /**
     * Get the investment progress (in percentage).
     */
    public function getProgress(): int
    {
        return $this->getInvestedAmount() * 100 / $this->fundingLimit;
    }

    /**
     * Has the project reached to funding limit?
     */
    public function isFunded(): bool
    {
        return $this->getInvestedAmount() >= $this->fundingLimit;
    }
}

