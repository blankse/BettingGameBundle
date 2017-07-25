<?php

namespace Blankse\BettingGameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="betting_game_tip")
 * @property-read integer $id
 */
class Tip
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     **/
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     **/
    public $type;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     **/
    public $reference;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     **/
    public $value;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var string
     **/
    public $score;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="tips")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @var \Blankse\BettingGameBundle\Entity\User
     **/
    public $user;

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
