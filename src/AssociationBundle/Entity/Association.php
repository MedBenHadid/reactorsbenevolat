<?php

namespace AssociationBundle\Entity;

use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(name="nom_agence", type="string", length=30, nullable=false)
     */
    private $nomAssociation;

    /**
     * @var integer
     *
     * @ORM\Column(name="telephone_agence", type="integer", nullable=false)
     */
    private $telephoneAssociation;

    /**
     * @var string
     *
     * @ORM\Column(name="type_agence", type="string", length=20, nullable=false)
     */
    private $typeAssociation;

    /**
     * @var string
     *
     * @ORM\Column(name="horaire_travail", type="string", length=20, nullable=false)
     */
    private $horaireTravail;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_agence", type="text", length=65535, nullable=false)
     */
    private $photoAssociation;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_manager", referencedColumnName="id")
     * })
     */
    private $manager;

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
     * @ORM\Column(name="statu", type="string", length=200, nullable=true)
     */
    private $status;

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
     * @ORM\Column(name="id_agence", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAssociation;



    /**
     * Set nomAssociation
     *
     * @param string $nomAssociation
     *
     * @return Association
     */
    public function setNomAssociation($nomAssociation)
    {
        $this->nomAssociation = $nomAssociation;

        return $this;
    }

    /**
     * Get nomAssociation
     *
     * @return string
     */
    public function getNomAssociation()
    {
        return $this->nomAssociation;
    }

    /**
     * Set telephoneAssociation
     *
     * @param integer $telephoneAssociation
     *
     * @return Association
     */
    public function setTelephoneAssociation($telephoneAssociation)
    {
        $this->telephoneAssociation = $telephoneAssociation;

        return $this;
    }

    /**
     * Get telephoneAssociation
     *
     * @return integer
     */
    public function getTelephoneAssociation()
    {
        return $this->telephoneAssociation;
    }

    /**
     * Set typeAssociation
     *
     * @param string $typeAssociation
     *
     * @return Association
     */
    public function setTypeAssociation($typeAssociation)
    {
        $this->typeAssociation = $typeAssociation;

        return $this;
    }

    /**
     * Get typeAssociation
     *
     * @return string
     */
    public function getTypeAssociation()
    {
        return $this->typeAssociation;
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
     * Set photoAssociation
     *
     * @param string $photoAssociation
     *
     * @return Association
     */
    public function setPhotoAssociation($photoAssociation)
    {
        $this->photoAssociation = $photoAssociation;

        return $this;
    }

    /**
     * Get photoAssociation
     *
     * @return string
     */
    public function getPhotoAssociation()
    {
        return $this->photoAssociation;
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
     * Set statu
     *
     * @param string $status
     *
     * @return Association
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
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
     * Get idAssociation
     *
     * @return integer
     */
    public function getIdAssociation()
    {
        return $this->idAssociation;
    }

    /**
     * Set manager
     *
     * @param \AppBundle\Entity\User $manager
     *
     * @return Association
     */
    public function setManager(\AppBundle\Entity\User $manager = null)
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * Get manager
     *
     * @return \AppBundle\Entity\User
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\User", mappedBy="association")
     */
    private $members;

    /**
     * @return Collection|User[]
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }
    public function addMember(User $member): self
    {
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
        }
        return $this;
    }
    public function removeMember(User $member): self
    {
        if ($this->members->contains($member)) {
            $this->members->removeElement($member);
        }
        return $this;
    }

    /**
     * Association constructor.
     */
    public function __construct()
    {
        $this->members = new ArrayCollection();

    }

}

