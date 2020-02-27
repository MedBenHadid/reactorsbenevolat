<?php

namespace MissionBundle\Entity;

use AppBundle\Entity\User;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Exception;

/**
 * MissionDonation
 *
 * @ORM\Table(name="mission_donation")
 * @ORM\Entity(repositoryClass="MissionBundle\Repository\MissionDonationRepository")
 */
class MissionDonation
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
     * @var User
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\User")
     *  @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="id_user", referencedColumnName="id", nullable=true)
     * })
     */
    private $id_user;
    /**
     *@var Mission
     * @ORM\ManyToOne(targetEntity="MissionBundle\Entity\Mission")
     * @JoinColumn(name="id_mission", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $id_mission;

    /**
     * @var float
     *
     * @ORM\Column(name="somme_donner", type="float")
     */
    private $sommeDonner;
    /**
     * @var DateTime
     *
     * @ORM\Column(name="dateDonation", type="date")
     */
    private $dateDonation;

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
    public function setIdUser(User $id_user): void
    {
        $this->id_user = $id_user;
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
    public function setIdMission(Mission $id_mission): void
    {
        $this->id_mission = $id_mission;
    }


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
    public function setId(int $id): void
    {
        $this->id = $id;
    }


    /**
     * @param \MissionBundle\Controller\DateTime $param
     * @return DateTime
     */
    public function getDateDonation(\MissionBundle\Controller\DateTime $param): DateTime
    {
        return $this->dateDonation;
    }

    /**
     * @param DateTime $dateDonation
     * @throws Exception
     */
    public function setDateDonation(DateTime $dateDonation): void
    {
        $this->dateDonation = new \DateTime("now");;
    }



    /**
     * @return float
     */
    public function getSommeDonner(): float
    {
        return $this->sommeDonner;
    }

    /**
     * @param float $sommeDonner
     */
    public function setSommeDonner(float $sommeDonner): void
    {
        $this->sommeDonner = $sommeDonner;
    }
    public function __construct()
    {
        $this->dateDonation = new \DateTime();
    }

}
