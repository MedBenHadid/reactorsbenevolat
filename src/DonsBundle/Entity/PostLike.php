<?php


namespace DonsBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="post_like")
 */
class PostLike
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\User", inversedBy="likes")
     */
    private $user;


    /**
     * @ORM\ManyToOne(targetEntity="\DonsBundle\Entity\Don", inversedBy="likes")
     */
    private $don;
    /**
     * @ORM\ManyToOne(targetEntity="\DonsBundle\Entity\Demande", inversedBy="likes")
     */
    private $demande;
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return PostLike
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
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
     * @return PostLike
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDon()
    {
        return $this->don;
    }

    /**
     * @param mixed $don
     * @return PostLike
     */
    public function setDon($don)
    {
        $this->don = $don;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDemande()
    {
        return $this->demande;
    }

    /**
     * @param mixed $demande
     * @return PostLike
     */
    public function setDemande($demande)
    {
        $this->demande = $demande;
        return $this;
    }


}