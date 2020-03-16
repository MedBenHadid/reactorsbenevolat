<?php

namespace MissionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Up
 *
 * @ORM\Table(name="up")
 * @ORM\Entity(repositoryClass="MissionBundle\Repository\UpRepository")
 */
class Up
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
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\User", inversedBy="likes")
     */
    private $user;


    /**
     * @ORM\ManyToOne(targetEntity="MissionBundle\Entity\Mission", inversedBy="likes")
     */
    private $mission;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Up
     */
    public function setId(int $id): Up
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return Up
     */
    public function setUser($user): Up
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMission()
    {
        return $this->mission;
    }

    /**
     * @param mixed $mission
     * @return Up
     */
    public function setMission($mission): Up
    {
        $this->mission = $mission;
        return $this;

    }

}
