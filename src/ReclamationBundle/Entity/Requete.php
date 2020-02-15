<?php

namespace ReclamationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Requete
 *
 * @ORM\Table(name="requete")
 * @ORM\Entity(repositoryClass="ReclamationBundle\Repository\RequeteRepository")
 */
class Requete
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
     * @var \DateTime
     *
     * @ORM\Column(name="DernierMAJ", type="datetime")
     */
    private $dernierMAJ;

    /**
     * @var int
     *
     * @ORM\Column(name="Statut", type="integer")
     */
    private $statut;

    /**
     * @var int
     *
     * @ORM\Column(name="Type", type="integer")
     */
    private $type;



    /**
     * @var int
     *
     * @ORM\Column(name="IdRep", type="integer", nullable=true, unique=true)
     */
    private $idRep;


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
     * @return Requete
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
     * Set dernierMAJ
     *
     * @param \DateTime $dernierMAJ
     *
     * @return Requete
     */
    public function setDernierMAJ($dernierMAJ)
    {
        $this->dernierMAJ = $dernierMAJ;

        return $this;
    }

    /**
     * Get dernierMAJ
     *
     * @return \DateTime
     */
    public function getDernierMAJ()
    {
        return $this->dernierMAJ;
    }

    /**
     * Set statut
     *
     * @param integer $statut
     *
     * @return Requete
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return int
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Requete
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }



    /**
     * Set idRep
     *
     * @param integer $idRep
     *
     * @return Requete
     */
    public function setIdRep($idRep)
    {
        $this->idRep = $idRep;

        return $this;
    }

    /**
     * Get idRep
     *
     * @return int
     */
    public function getIdRep()
    {
        return $this->idRep;
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

