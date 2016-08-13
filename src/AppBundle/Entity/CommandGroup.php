<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * CommandGroup
 *
 * @ORM\Table(name="command_group")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommandGroupRepository")
 * @UniqueEntity("slug")
 */
class CommandGroup
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;


    /**
     * @var \AppBundle\Entity\Command
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Command",mappedBy="group")
     */
    private $commands;

    /**
     * CommandGroup constructor.
     */
    public function __construct()
    {
        $this->commands = new ArrayCollection();
    }


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
     * Set title
     *
     * @param string $title
     *
     * @return CommandGroup
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
     * Set slug
     *
     * @param string $slug
     *
     * @return CommandGroup
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
     * @return Command[]
     */
    public function getCommands()
    {
        return $this->commands;
    }

    /**
     * @param Command[] $commands
     */
    public function setCommands($commands)
    {
        $this->commands = $commands;
    }

    /**
     * Add command
     * @param Command $command
     * @return Command[]
     */
    public function addCommand(Command $command)
    {
        if(!$this->commands->contains($command)){
            $this->commands->add($command);
        }

        return $this->commands;
    }

    /**
     * Add command
     * @param Command $command
     * @return Command[]
     */
    public function removeCommand(Command $command)
    {
        $this->commands->removeElement($command);

        return $this->commands;
    }
}

