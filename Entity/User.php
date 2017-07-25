<?php

namespace Blankse\BettingGameBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="betting_game_user")
 * @property-read integer $id
 */
class User
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
    public $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     **/
    public $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     **/
    public $address;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @var int
     **/
    public $position;

    /**
     * @ORM\Column(type="integer")
     * @var int
     **/
    public $score;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     **/
    public $paid;

    /**
     * @ORM\OneToMany(targetEntity="Tip", mappedBy="user")
     * var \Doctrine\Common\Collections\ArrayCollection
     */
    public $tips;

    public function __construct()
    {
        $this->tips = new ArrayCollection();
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
