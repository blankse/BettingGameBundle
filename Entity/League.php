<?php

namespace Blankse\BettingGameBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="betting_game_league")
 * @property-read integer $id
 */
class League
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     **/
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     **/
    public $name;

    /**
     * @ORM\Column(type="integer")
     **/
    public $promotionCount;

    /**
     * @ORM\Column(type="integer")
     **/
    public $promotionPlayOffsCount;

    /**
     * @ORM\Column(type="integer")
     **/
    public $relegationCount;

    /**
     * @ORM\Column(type="integer")
     **/
    public $relegationPlayOffsCount;

    /**
     * @ORM\OneToMany(targetEntity="Team", mappedBy="league")
     * @ORM\OrderBy({"name" = "ASC"})
     * var \Doctrine\Common\Collections\ArrayCollection
     */
    public $teams;

    /**
     * @ORM\OneToMany(targetEntity="Match", mappedBy="league")
     * var \Doctrine\Common\Collections\ArrayCollection
     */
    public $matches;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->matches = new ArrayCollection();
    }

    /**
     * Magic getter for retrieving convenience properties
     *
     * @param string $property The name of the property to retrieve
     *
     * @return mixed
     */
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }

        return null;
    }

    /**
     * Magic isset function handling isset() to non public properties
     *
     * Returns true for all (public/)protected/private properties.
     *
     * @ignore This method is for internal use
     * @access private
     *
     * @param string $property Name of the property
     *
     * @return boolean
     */
    public function __isset($property)
    {
        return property_exists($this, $property);
    }
}
