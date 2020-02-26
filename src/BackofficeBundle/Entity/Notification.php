<?php

namespace BackofficeBundle\Entity;

use AssociationBundle\Entity\Association;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use MissionBundle\Entity\Invitation;
use MissionBundle\Entity\Mission;
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
     * @var Mission
     *
     * @ORM\ManyToOne(targetEntity="MissionBundle\Entity\Mission")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_mission", referencedColumnName="id")
     * })
     */
    private $id_mission;
    /**
     * @var Association
     *
     * @ORM\ManyToOne(targetEntity="AssociationBundle\Entity\Association")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_association", referencedColumnName="id")
     * })
     */
    private $id_association;


    /**
     *@var Invitation
     * @OneToOne(targetEntity="MissionBundle\Entity\Invitation")
     * @JoinColumn(name="id_invitation", referencedColumnName="id",nullable=true)
     */
    private $id_invitation;
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
     * @return Association
     */
    public function getIdAssociation(): Association
    {
        return $this->id_association;
    }

    /**
     * @param Association $id_association
     */
    public function setIdAssociation(Association $id_association)
    {
        $this->id_association = $id_association;
    }

    /**
     * @return Mission
     */
    public function getIdMission(): Mission
    {
        return $this->id_mission;
    }

    /**
     * @param Mission $id_mission
     */
    public function setIdMission(Mission $id_mission)
    {
        $this->id_mission = $id_mission;
    }

    /**
     * @return Invitation|null
     */
    public function getIdInvitation():? Invitation
    {
        return $this->id_invitation;
    }

    /**
     * @param Invitation $id_invitation
     */
    public function setIdInvitation(Invitation $id_invitation)
    {
        $this->id_invitation = $id_invitation;
    }



}

