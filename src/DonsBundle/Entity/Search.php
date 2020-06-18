<?php

namespace DonsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


class Search
{

    /**
     * @var int
     *
     */
    private $ups;

    /**
     * @var String | null
     */
    private $title;
    /**
     * Set ups.
     *
     * @param int $ups
     *
     * @return Search
     */
    public function setUps($ups)
    {
        $this->ups = $ups;

        return $this;
    }

    /**
     * Get ups.
     *
     * @return int
     */
    public function getUps()
    {
        return $this->ups;
    }

    /**
     * @return String|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param String|null $title
     * @return Search
     */
    public function setTitle(String $title)
    {
        $this->title = $title;
        return $this;
    }



}
