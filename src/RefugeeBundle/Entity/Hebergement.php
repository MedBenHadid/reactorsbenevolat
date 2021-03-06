<?php

namespace RefugeeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hebergement
 *
 * @ORM\Table(name="hebergement")
 * @ORM\Entity(repositoryClass="RefugeeBundle\Repository\HebergementRepository")
 */
class Hebergement
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
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="governorat", type="string", length=50)
     */
    private $governorat;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_rooms", type="integer")
     */
    private $nbrRooms;

    /**
     * @var int
     *
     * @ORM\Column(name="duration", type="integer")
     */
    private $duration;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="date")
     */
    private $creationDate;

    /**
     * @var int
     *
     * @ORM\Column(name="state", type="integer")
     */
    private $state;


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
     * Set description
     *
     * @param string $description
     *
     * @return Hebergement
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
     * Set governorat
     *
     * @param string $governorat
     *
     * @return Hebergement
     */
    public function setGovernorat($governorat)
    {
        $this->governorat = $governorat;

        return $this;
    }

    /**
     * Get governorat
     *
     * @return string
     */
    public function getGovernorat()
    {
        return $this->governorat;
    }

    /**
     * Set nbrRooms
     *
     * @param integer $nbrRooms
     *
     * @return Hebergement
     */
    public function setNbrRooms($nbrRooms)
    {
        $this->nbrRooms = $nbrRooms;

        return $this;
    }

    /**
     * Get nbrRooms
     *
     * @return int
     */
    public function getNbrRooms()
    {
        return $this->nbrRooms;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     *
     * @return Hebergement
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Hebergement
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=255)
     */
    private $telephone;

    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * Set state
     *
     * @param integer $state
     *
     * @return Hebergement
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    public function __toString()
    {
        return strval($this->id);
    }

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image)
    {
        $this->image = $image;
    }
}

