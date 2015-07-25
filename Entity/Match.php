<?php

namespace Blankse\BettingGameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="betting_game_match")
 * @property-read integer $id
 */
class Match
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     **/
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     **/
    public $date;

    /**
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="matches")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id")
     * @var \Blankse\BettingGameBundle\Entity\Team
     **/
    public $team;

    /**
     * @ORM\Column(type="string", length=255)
     **/
    public $opponent;

    /**
     * @ORM\Column(type="boolean")
     **/
    public $awayGame;

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
