<?php

namespace AssociationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gouvernerat
 *
 * @ORM\Table(name="gouvernerat")
 * @ORM\Entity(repositoryClass="AssociationBundle\Repository\GouverneratRepository")
 */
class Gouvernerat
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

