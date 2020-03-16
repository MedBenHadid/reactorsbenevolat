<?php

namespace MissionBundle\Entity;

use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Mission
 *
 * @ORM\Table(name="mission")
 * @ORM\Entity(repositoryClass="MissionBundle\Repository\MissionRepository")
 */
class Mission
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
     * @ORM\Column(name="TitleMission", type="string", length=255)
     */
    private $titleMission;

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="text", length=65535, nullable=false)
     */
    private $picture;

    /**
     * @var string
     * @ORM\Column(type="text", length=300)
     * @Assert\NotBlank(message="Veuillez insérer une description de votre Mission")
     * @Assert\Length(
     *     max=300,
     *     maxMessage="La description ne peut pas dépasser 300 caractéres"
     * )
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255)
     */
    private $location;


    /**
     * @var float
     *
     * @ORM\Column(name="sumCollected", type="float")
     */
    private $sumCollected;
    /**
     * @var float
     *
     * @ORM\Column(name="objectif", type="float")
     */
    private $objectif;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateCreation", type="date")
     */
    private $dateCreation;
    /**
     * @var int
     *
     * @ORM\Column(name="ups", type="integer")
     */
    private $ups;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateFin", type="date")
     */
    private $dateFin;

    /**
     * @ORM\ManyToOne(targetEntity="AssociationBundle\Entity\Category",inversedBy="mission")
     */
    private $domaine;
    /**
     * Get id
     *
     * @return int
     */

    /**
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\User")
     *  @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="CreatedBy", referencedColumnName="id", nullable=true)
     * })
     */
    private $CreatedBy;
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
     * @ORM\OneToMany(targetEntity="MissionBundle\Entity\Up", mappedBy="mission")
     */
    private $likes;


    public function __construct()
    {
        $this->likes = new ArrayCollection();
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude(float $latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude(float $longitude)
    {
        $this->longitude = $longitude;
    }
    /**
     * Get string
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titleMission
     *
     * @param string $titleMission
     *
     * @return Mission
     */
    public function setTitleMission($titleMission)
    {
        $this->titleMission = $titleMission;

        return $this;
    }

    /**
     * Get titleMission
     *
     * @return string
     */
    public function getTitleMission()
    {
        return $this->titleMission;
    }

    /**
     * Set picture
     *
     * @param string $picture
     *
     * @return Mission
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Mission
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
     * Set location
     *
     * @param string $location
     *
     * @return Mission
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Mission
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Mission
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }
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
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @return float
     */
    public function getSumCollected(): float
    {
        return $this->sumCollected;
    }

    /**
     * @param float $sumCollected
     */
    public function setSumCollected(float $sumCollected)
    {
        $this->sumCollected = $sumCollected;
    }

    /**
     * @return float
     */
    public function getObjectif()
    {
        return $this->objectif;
    }

    /**
     * @param float $objectif
     */
    public function setObjectif(float $objectif)
    {
        $this->objectif = $objectif;
    }

    /**
     * @return int
     */
    public function getUps(): int
    {
        return $this->ups;
    }

    /**
     * @param int $ups
     */
    public function setUps(int $ups)
    {
        $this->ups = $ups;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->CreatedBy;
    }

    /**
     * @param mixed $CreatedBy
     */
    public function setCreatedBy($CreatedBy)
    {
        $this->CreatedBy = $CreatedBy;
    }
    
    
    
    /**
     * @return Collection|Up[]
     */
    public function getLikes()
    {
        return $this->likes;
    }

    public function addLike(Up $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setMission($this);
        }

        return $this;
    }

    public function removeLike(Up $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            // set the owning side to null (unless already changed)
            if ($like->getMission() === $this) {
                $like->setMission(null);
            }
        }

        return $this;
    }

    public function isLikedByUser(User $user): bool
    {
        foreach ($this->likes as $like) {
            if ($like->getUser() === $user) {
                return true;
            }
        }

        return false;
    }
}

