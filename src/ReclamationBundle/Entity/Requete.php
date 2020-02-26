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
     * @ORM\Column(name="Sujet", type="string")
     */
    private $sujet;
    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text")
     */
    private $description;


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
     * Set description
     *
     * @param string $description
     *
     * @return Requete
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
     * @ORM\OneToOne(targetEntity="Rponse")
     * @ORM\JoinColumn(nullable=true)
     */
    private $rponse;

    /**
     * @return mixed
     */
    public function getRponse()
    {
        return $this->rponse;
    }

    /**
     * @param mixed $rponse
     */
    public function setRponse($rponse)
    {
        $this->rponse = $rponse;
    }
    public function __toString(){
        // to show the name of the Category in the select
        return $this->sujet;
        // to show the id of the Category in the select
        // return $this->id;
    }
}

