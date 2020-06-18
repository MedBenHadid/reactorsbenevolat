<?php

namespace AssociationBundle\Entity;

use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Association
 *
 * @ORM\Table(name="association", indexes={@ORM\Index(name="id_manager", columns={"id_manager"})})
 * @ORM\Entity(repositoryClass="AssociationBundle\Repository\AssociationRepository")
 */
class Association
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30, nullable=false)
     */
    private $nom;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $telephone;

    /**
     * @ORM\ManyToOne(targetEntity="AssociationBundle\Entity\Category", inversedBy="association",fetch="EXTRA_LAZY")
     */
    private $domaine;

    /**
     * @var string
     *
     * @ORM\Column(name="horaire_travail", type="string", length=255, nullable=false)
     */
    private $horaireTravail;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_agence", type="text", length=65535, nullable=false)
     */
    private $photo;

    /**
     * @var User
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User",fetch="EXTRA_LAZY")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_manager", referencedColumnName="id")
     * })
     */
    private $manager;

    /**
     * @ORM\OneToMany(targetEntity="AssociationBundle\Entity\Adherance", mappedBy="association", fetch="EXTRA_LAZY")
     */
    private $memberships;

    /**
     * @var string
     *
     * @ORM\Column(name="piece_justificatif", type="text", length=65535, nullable=false)
     */
    private $pieceJustificatif;

    /**
     * @var string
     *
     * @ORM\Column(name="rue", type="string", length=200, nullable=true)
     */
    private $rue;

    /**
     * @var integer
     *
     * @ORM\Column(name="code_postal", type="integer", nullable=true)
     */
    private $codePostal;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=200, nullable=true)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="MissionBundle\Entity\Mission", inversedBy="missions", fetch="EXTRA_LAZY")
     */
    private $missions;

    /**
     * @param mixed $missions
     */
    public function setMissions($missions)
    {
        $this->missions = $missions;
    }

    /**
     * @return mixed
     */
    public function getMissions()
    {
        return $this->missions;
    }



    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

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
     * @var boolean
     *
     * @ORM\Column(name="approuved", type="boolean", nullable=false)
     */
    private $approuved = false;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Association
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
     * Set telephone
     *
     * @param integer $telephone
     *
     * @return Association
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
     * Set horaireTravail
     *
     * @param string $horaireTravail
     *
     * @return Association
     */
    public function setHoraireTravail($horaireTravail)
    {
        $this->horaireTravail = $horaireTravail;

        return $this;
    }

    /**
     * Get horaireTravail
     *
     * @return string
     */
    public function getHoraireTravail()
    {
        return $this->horaireTravail;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return Association
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set pieceJustificatif
     *
     * @param string $pieceJustificatif
     *
     * @return Association
     */
    public function setPieceJustificatif($pieceJustificatif)
    {
        $this->pieceJustificatif = $pieceJustificatif;

        return $this;
    }

    /**
     * Get pieceJustificatif
     *
     * @return string
     */
    public function getPieceJustificatif()
    {
        return $this->pieceJustificatif;
    }

    /**
     * Set rue
     *
     * @param string $rue
     *
     * @return Association
     */
    public function setRue($rue)
    {
        $this->rue = $rue;

        return $this;
    }

    /**
     * Get rue
     *
     * @return string
     */
    public function getRue()
    {
        return $this->rue;
    }

    /**
     * Set codePostal
     *
     * @param integer $codePostal
     *
     * @return Association
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return integer
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Association
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }


    /**
     * Set latitude
     *
     * @param float $latitude
     *
     * @return Association
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     *
     * @return Association
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set approuved
     *
     * @param boolean $approuved
     *
     * @return Association
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set manager
     *
     * @param User $manager
     *
     * @return Association
     */
    public function setManager(User $manager = null)
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * @param mixed $membershipships
     */
    public function setMembershipships($membershipships)
    {
        $this->membershipships = $membershipships;
    }

    /**
     * Get manager
     *
     * @return User
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @return mixed
     */
    public function getDomaine()
    {
        return $this->domaine;
    }

    /**
     * @param mixed $domaine
     */
    public function setDomaine($domaine)
    {
        $this->domaine = $domaine;
    }


    /**
     * @return Collection|User[]
     */
    public function getMemberships(): Collection
    {
        return $this->memberships;
    }
    public function addMembership(User $member): self
    {
        if (!$this->memberships->contains($member)) {
            $this->memberships[] = $member;
        }
        return $this;
    }
    public function removeMembership(User $member): self
    {
        if ($this->memberships->contains($member)) {
            $this->memberships->removeElement($member);
        }
        return $this;
    }

    /**
     * Association constructor.
     */
    public function __construct()
    {
        $this->memberships = new ArrayCollection();

    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getNom();
    }

    public function getMembers()
    {
        $members = new ArrayCollection();
        $memberships = $this->getMemberships();
        foreach ($memberships as $membership) {
            $members->add($membership->getUser());
        }
        return $members;
    }

}

