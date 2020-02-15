<?php

namespace RefugeeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Refugee
 *
 * @ORM\Table(name="refugee")
 * @ORM\Entity(repositoryClass="RefugeeBundle\Repository\RefugeeRepository")
 */
class Refugee
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
     * @ORM\Column(name="native_country", type="string", length=255)
     */
    private $nativeCountry;

    /**
     * @var string
     *
     * @ORM\Column(name="case_description", type="text")
     */
    private $caseDescription;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nativeCountry
     *
     * @param string $nativeCountry
     *
     * @return Refugee
     */
    public function setNativeCountry($nativeCountry)
    {
        $this->nativeCountry = $nativeCountry;

        return $this;
    }

    /**
     * Get nativeCountry
     *
     * @return string
     */
    public function getNativeCountry()
    {
        return $this->nativeCountry;
    }

    /**
     * Set caseDescription
     *
     * @param string $caseDescription
     *
     * @return Refugee
     */
    public function setCaseDescription($caseDescription)
    {
        $this->caseDescription = $caseDescription;

        return $this;
    }

    /**
     * Get caseDescription
     *
     * @return string
     */
    public function getCaseDescription()
    {
        return $this->caseDescription;
    }

    /**
     * Set arrivalDate
     *
     * @param \DateTime $arrivalDate
     *
     * @return Refugee
     */
    public function setArrivalDate($arrivalDate)
    {
        $this->arrivalDate = $arrivalDate;

        return $this;
    }

    /**
     * Get arrivalDate
     *
     * @return \DateTime
     */
    public function getArrivalDate()
    {
        return $this->arrivalDate;
    }

    /**
     * Set passportNumber
     *
     * @param string $passportNumber
     *
     * @return Refugee
     */
    public function setPassportNumber($passportNumber)
    {
        $this->passportNumber = $passportNumber;

        return $this;
    }

    /**
     * Get passportNumber
     *
     * @return string
     */
    public function getPassportNumber()
    {
        return $this->passportNumber;
    }

    /**
     * Set civilStatus
     *
     * @param integer $civilStatus
     *
     * @return Refugee
     */
    public function setCivilStatus($civilStatus)
    {
        $this->civilStatus = $civilStatus;

        return $this;
    }

    /**
     * Get civilStatus
     *
     * @return int
     */
    public function getCivilStatus()
    {
        return $this->civilStatus;
    }

    /**
     * Set childrenNumber
     *
     * @param integer $childrenNumber
     *
     * @return Refugee
     */
    public function setChildrenNumber($childrenNumber)
    {
        $this->childrenNumber = $childrenNumber;

        return $this;
    }

    /**
     * Get childrenNumber
     *
     * @return int
     */
    public function getChildrenNumber()
    {
        return $this->childrenNumber;
    }

    /**
     * @ORM\OneToOne(targetEntity="\AppBundle\Entity\User")
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


}

