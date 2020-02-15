<?php

namespace ReclamationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rponse
 *
 * @ORM\Table(name="rponse")
 * @ORM\Entity(repositoryClass="ReclamationBundle\Repository\RponseRepository")
 */
class Rponse
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
     * @ORM\Column(name="Sujet", type="text")
     */
    private $sujet;

    /**
     * @var string
     *
     * @ORM\Column(name="Rep", type="text")
     */
    private $rep;

    /**
     * @var int
     *
     * @ORM\Column(name="IdReq", type="integer", unique=true)
     */
    private $idReq;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date", type="datetime")
     */
    private $date;




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
     * Set sujet
     *
     * @param string $sujet
     *
     * @return Rponse
     */
    public function setSujet($sujet)
    {
        $this->sujet = $sujet;

        return $this;
    }

    /**
     * Get sujet
     *
     * @return string
     */
    public function getSujet()
    {
        return $this->sujet;
    }

    /**
     * Set rep
     *
     * @param string $rep
     *
     * @return Rponse
     */
    public function setRep($rep)
    {
        $this->rep = $rep;

        return $this;
    }

    /**
     * Get rep
     *
     * @return string
     */
    public function getRep()
    {
        return $this->rep;
    }

    /**
     * Set idReq
     *
     * @param integer $idReq
     *
     * @return Rponse
     */
    public function setIdReq($idReq)
    {
        $this->idReq = $idReq;

        return $this;
    }

    /**
     * Get idReq
     *
     * @return int
     */
    public function getIdReq()
    {
        return $this->idReq;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Rponse
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
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
}

