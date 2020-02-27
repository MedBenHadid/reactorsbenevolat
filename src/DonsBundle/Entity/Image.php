<?php

namespace DonsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 *
 * @ORM\Table(name="imageDon")
 * @ORM\Entity(repositoryClass="DonsBundle\Repository\ImageRepository")
 */
class Image
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
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;




    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Don")
     * @ORM\JoinColumn(nullable=true)
     */
    private $don;



    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Demande")
     * @ORM\JoinColumn(nullable=true)
     */
    private $demande;





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
     * Set image
     *
     * @param string $image
     *
     * @return Image
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
     * @return mixed
     */
    public function getDon()
    {
        return $this->don;
    }

    /**
     * @param mixed $don
     */
    public function setDon($don)
    {
        $this->don = $don;
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
     */
    public function setDemande($demande)
    {
        $this->demande = $demande;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->don;
    }
}

