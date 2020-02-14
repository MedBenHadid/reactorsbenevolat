<?php

namespace AppBundle\Entity;

use AssociationBundle\Entity\Association;
use AssociationBundle\Entity\Invitation;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    const SUPER_ADMIN = "ROLE_SUPER_ADMIN";
    const ASSOCIATION_ADMIN = "ROLE_ASSOCIATION_ADMIN";
    const LIVREUR = "ROLE_LIVREUR";
    const USER = "ROLE_USER";
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

/*
    /**
     * @ORM\OneToOne(targetEntity="AssociationBundle\Entity\Invitation")
     * @ORM\JoinColumn(referencedColumnName="code")
     * @Assert\NotNull(message="Your invitation is wrong", groups={"Registration"})
     */
    //protected $invitation;

    public function __construct()
    {
        parent::__construct();
    }

    public function setInvitation(Invitation $invitation)
    {
        $this->invitation = $invitation;
    }

    public function getInvitation()
    {
        return $this->invitation;
    }

}

