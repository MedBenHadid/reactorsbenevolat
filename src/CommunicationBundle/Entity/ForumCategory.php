<?php

namespace CommunicationBundle\Entity;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints as Recaptcha;

use Doctrine\ORM\Mapping as ORM;

/**
 * ForumCategory
 *
 * @ORM\Table(name="forum_category")
 * @ORM\Entity(repositoryClass="CommunicationBundle\Repository\ForumCategoryRepository")
 */
class ForumCategory
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="describtion", type="string", length=255)
     */
    private $describtion;


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
     * Set name
     *
     * @param string $name
     *
     * @return ForumCategory
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set describtion
     *
     * @param string $describtion
     *
     * @return ForumCategory
     */
    public function setDescribtion($describtion)
    {
        $this->describtion = $describtion;

        return $this;
    }

    /**
     * Get describtion
     *
     * @return string
     */
    public function getDescribtion()
    {
        return $this->describtion;
    }
    /**
     * @Recaptcha\IsTrue
     */
    public $recaptcha;

    public function __toString() {
        return $this->name;
    }
}

