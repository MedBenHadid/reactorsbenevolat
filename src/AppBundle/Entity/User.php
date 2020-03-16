<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User extends BaseUser
{
    const SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
    const ASSOCIATION_ADMIN = 'ROLE_ASSOCIATION_ADMIN';
    const LIVREUR = 'ROLE_LIVREUR';
    const USER = 'ROLE_USER';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=20,nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=20,nullable=true)
     */
    private $prenom;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_naissance", type="date", nullable=true)
     */
    private $dateNaissance;

    /**
     * @var integer
     *
     * @ORM\Column(name="telephone", type="integer",nullable=true)
     */
    private $telephone;


    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=50, nullable=true)
     */
    private $adresse;

    /**
     * @var boolean
     *
     * @ORM\Column(name="approuved", type="boolean", nullable=true)
     */
    private $approuved;
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_admin", type="boolean", nullable=true)
     */
    private $isAdmin = false;
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_ass_admin", type="boolean", nullable=true)
     */
    private $isAssAdmin = false ;

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    /**
     * @param bool $isAdmin
     */
    public function setIsAdmin(bool $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }

    /**
     * @return bool
     */
    public function isAssAdmin(): bool
    {
        return $this->isAssAdmin;
    }

    /**
     * @param bool $isAssAdmin
     */
    public function setIsAssAdmin(bool $isAssAdmin): void
    {
        $this->isAssAdmin = $isAssAdmin;
    }

    /**
     * @return bool
     */
    public function isMember(): bool
    {
        return $this->isMember;
    }

    /**
     * @param bool $isMember
     */
    public function setIsMember(bool $isMember): void
    {
        $this->isMember = $isMember;
    }


    /**
     * @var boolean
     *
     * @ORM\Column(name="is_member", type="boolean", nullable=true)
     */
    private $isMember = false;
    /**
     * @var boolean
     *
     * @ORM\Column(name="banned", type="boolean")
     */
    private $banned = false;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="text", length=65535, nullable=true)
     */
    private $image = "user.png";


    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }


    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return User
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * @ORM\Column(type="string",nullable=true)
     * @Assert\Length(max="8",min="8",maxMessage="CIN ne peut pas dépasser 8 caractéres")
     */
    private $cin;

    /**
     * @return mixed
     */
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * @param mixed $cin
     */
    public function setCin($cin)
    {
        $this->cin = $cin;
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
     * @ORM\OneToMany(targetEntity="AssociationBundle\Entity\Adherance", mappedBy="user")
     */
    private $association;

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set telephone
     *
     * @param integer $telephone
     *
     * @return User
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return integer
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return User
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set approuved
     *
     * @param boolean $approuved
     *
     * @return User
     */
    public function setApprouved($approuved)
    {
        $this->approuved = $approuved;

        return $this;
    }

    /**
     * Get approuved
     *
     * @return boolean
     */
    public function getApprouved()
    {
        return $this->approuved;
    }

    /**
     * Set banned
     *
     * @param boolean $banned
     *
     * @return User
     */
    public function setBanned($banned)
    {
        $this->banned = $banned;

        return $this;
    }

    /**
     * Get banned
     *
     * @return boolean
     */
    public function getBanned()
    {
        return $this->banned;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return User
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }


}

