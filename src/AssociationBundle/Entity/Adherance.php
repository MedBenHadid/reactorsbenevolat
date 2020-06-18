<?php

namespace AssociationBundle\Entity;

use AppBundle\Entity\User;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Adherance
 *
 * @ORM\Table(name="adherance")
 * @ORM\Entity(repositoryClass="AssociationBundle\Repository\AdheranceRepository")
 */
class Adherance
{
    public const WRITE = 1;
    public const READ = 2;
    public const DELIVER = 3;

    public const INVITE_PENDING = "INVITE_PENDING";
    public const REQUEST_PENDING = "REQUEST_PENDING";
    public const DENIED_BY_USER = "DENIED_BY_USER";
    public const DENIED_BY_ASS = "DENIED_BY_ASS";
    public const ACCEPTED = "ACCEPTED";

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var $user User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User",inversedBy="adherance", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="AssociationBundle\Entity\Association", inversedBy="adherance", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(nullable=false)
     */
    private $association;


    /**
     * @var datetime $joinedAt
     * @ORM\Column(name="joined", type="datetime")
     */
    private $joinedAt ;


    /**
     * @ORM\Column(type="string")
     */
    private $fonction ;

    /**
     * @ORM\Column(type="string")
     */
    private $description ;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $longitude;

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role): void
    {
        $this->role = $role;
    }

    /**
     * @ORM\Column(type="integer")
     */
    private $role;

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @ORM\Column(type="string")
     */
    private $status;

    /**
     * @return mixed
     */
    public function getFonction()
    {
        return $this->fonction;
    }

    /**
     * @param mixed $fonction
     */
    public function setFonction($fonction)
    {
        $this->fonction = $fonction;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
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
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    public function __toString()
    {
        return $this->user->getUsername();
    }

    /**
     * @return mixed
     */
    public function getAssociation()
    {
        return $this->association;
    }

    /**
     * @param mixed $association
     */
    public function setAssociation($association)
    {
        $this->association = $association;
    }

    /**
     * @return DateTime
     */
    public function getJoinedAt(): DateTime
    {
        return $this->joinedAt;
    }

    public function __construct()
    {
        $this->joinedAt = new \DateTime();
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }


}
