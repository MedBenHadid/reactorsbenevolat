<?php

namespace MissionBundle\Entity;

use AppBundle\Entity\User;
use AssociationBundle\Entity\Association;
use BackofficeBundle\Entity\Notification;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use MissionBundle\Entity\Mission;

/**
 * Invitation
 *
 * @ORM\Table(name="invitation")
 * @ORM\Entity(repositoryClass="MissionBundle\Repository\InvitationRepository")
 */
class Invitation
{
    const invite = "inviter";
    const accepter ="accepter";
    const réfuser ="réfuser";

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Mission
     *
     * @ORM\ManyToOne(targetEntity="MissionBundle\Entity\Mission", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_mission", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     * })
     */
    private $id_mission;

    /**
     *@var Notification
     * @OneToOne(targetEntity="BackofficeBundle\Entity\Notification")
     * @JoinColumn(name="id_notification", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $id_notification;


    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $id_user;


    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", columnDefinition="enum('inviter', 'accepter','réfuser')")
     */
    private $etat='inviter' ;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
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

    /**
     * @return Notification
     */
    public function getIdNotification(): Notification
    {
        return $this->id_notification;
    }

    /**
     * @param Notification $id_notification
     */
    public function setIdNotification(Notification $id_notification)
    {
        $this->id_notification = $id_notification;
    }

    /**
     * @return User
     */
    public function getIdUser(): User
    {
        return $this->id_user;
    }

    /**
     * @param User $id_user
     */
    public function setIdUser(User $id_user)
    {
        $this->id_user = $id_user;
    }

    /**
     * @return string
     */
    public function getEtat(): string
    {
        return $this->etat;
    }

    /**
     * @param string $etat
     */
    public function setEtat(string $etat)
    {
        $this->etat = $etat;
    }

}
