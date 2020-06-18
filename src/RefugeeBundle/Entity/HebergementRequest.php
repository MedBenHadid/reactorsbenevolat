<?php

namespace RefugeeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HebergementRequest
 *
 * @ORM\Table(name="hebergement_request")
 * @ORM\Entity(repositoryClass="RefugeeBundle\Repository\HebergementRequestRepository")
 */
class HebergementRequest
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
     * @ORM\Column(name="description", type="text")
     */
    private $description;


    /**
     * @var string
     *
     * @ORM\Column(name="native_country", type="string", length=255)
     */
    private $nativeCountry;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="arrival_date", type="date")
     */
    private $arrivalDate;

    /**
     * @var string
     *
     * @ORM\Column(name="passport_number", type="string", length=255)
     */
    private $passportNumber;

    /**
     * @var int
     *
     * @ORM\Column(name="civil_status", type="integer")
     */
    private $civilStatus;

    /**
     * @var int
     *
     * @ORM\Column(name="children_number", type="integer")
     */
    private $childrenNumber;

    /**
     * @return string
     */
    public function getNativeCountry()
    {
        return $this->nativeCountry;
    }

    /**
     * @param string $nativeCountry
     */
    public function setNativeCountry($nativeCountry)
    {
        $this->nativeCountry = $nativeCountry;
    }


    public function getArrivalDate()
    {
        return $this->arrivalDate;
    }

    /**
     * @param \DateTime $arrivalDate
     */
    public function setArrivalDate($arrivalDate)
    {
        $date = new \DateTime($arrivalDate);
        $this->arrivalDate = $date;
    }

    /**
     * @return string
     */
    public function getPassportNumber()
    {
        return $this->passportNumber;
    }

    /**
     * @param string $passportNumber
     */
    public function setPassportNumber($passportNumber)
    {
        $this->passportNumber = $passportNumber;
    }

    /**
     * @return int
     */
    public function getCivilStatus()
    {
        return $this->civilStatus;
    }

    /**
     * @param int $civilStatus
     */
    public function setCivilStatus($civilStatus)
    {
        $this->civilStatus = $civilStatus;
    }

    /**
     * @return int
     */
    public function getChildrenNumber()
    {
        return $this->childrenNumber;
    }

    /**
     * @param int $childrenNumber
     */
    public function setChildrenNumber($childrenNumber)
    {
        $this->childrenNumber = $childrenNumber;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

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
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=255)
     */
    private $region;


    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=255)
     */
    private $telephone;

    /**
     * @var int
     *
     * @ORM\Column(name="state", type="integer")
     */
    private $state;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="date")
     */
    private $creationDate;

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
     * @return HebergementRequest
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
     * Set region
     *
     * @param string $region
     *
     * @return HebergementRequest
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set state
     *
     * @param integer $state
     *
     * @return HebergementRequest
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

    /**
     * @var int
     *
     * @ORM\Column(name="is_anonymous", type="integer")
     */
    private $isAnonymous;

    /**
     * @return int
     */
    public function getIsAnonymous()
    {
        return $this->isAnonymous;
    }

    /**
     * @param int $isAnonymous
     */
    public function setIsAnonymous($isAnonymous)
    {
        $this->isAnonymous = $isAnonymous;
    }


}

