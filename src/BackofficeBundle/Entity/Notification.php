<?php

namespace BackofficeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SBC\NotificationsBundle\Model\BaseNotification;

/**
 * Notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="BackofficeBundle\Repository\NotificationRepository")
 */
class Notification extends  BaseNotification implements \JsonSerializable
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
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $id_user;

    /**
     * @var \MissionBundle\Entity\Mission
     *
     * @ORM\ManyToOne(targetEntity="MissionBundle\Entity\Mission")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_mission", referencedColumnName="id")
     * })
     */
    private $id_mission;
    /**
     * @var \AssociationBundle\Entity\Association
     *
     * @ORM\ManyToOne(targetEntity="AssociationBundle\Entity\Association")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_association", referencedColumnName="id")
     * })
     */
    private $id_association;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    /**
     * @return \AppBundle\Entity\User
     */
    public function getIdUser(): \AppBundle\Entity\User
    {
        return $this->id_user;
    }

    /**
     * @param \AppBundle\Entity\User $id_user
     */
    public function setIdUser(\AppBundle\Entity\User $id_user)
    {
        $this->id_user = $id_user;
    }

    /**
     * @return \AssociationBundle\Entity\Association
     */
    public function getIdAssociation(): \AssociationBundle\Entity\Association
    {
        return $this->id_association;
    }

    /**
     * @param \AssociationBundle\Entity\Association $id_association
     */
    public function setIdAssociation(\AssociationBundle\Entity\Association $id_association)
    {
        $this->id_association = $id_association;
    }

    /**
     * @return \MissionBundle\Entity\Mission
     */
    public function getIdMission(): \MissionBundle\Entity\Mission
    {
        return $this->id_mission;
    }

    /**
     * @param \MissionBundle\Entity\Mission $id_mission
     */
    public function setIdMission(\MissionBundle\Entity\Mission $id_mission)
    {
        $this->id_mission = $id_mission;
    }


}

