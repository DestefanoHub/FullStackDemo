<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 7/7/16
 * Time: 11:49 AM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;

/**
 * Class BattleMech
 * @package AppBundle\Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repositories\BattleMechRepo")
 * @ORM\Table(name="battlemechs")
 * @ORM\HasLifecycleCallbacks()
 *
 * @JMS\ExclusionPolicy("all")
 */
class BattleMech
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @JMS\Expose()
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="chassis_name", type="string", length=40)
     * @Assert\NotBlank(
     *      message="A BattleMech's name cannot be blank."
     * )
     * @Assert\Length(
     *      min=5,
     *      max=40,
     *      minMessage="The name of a BattleMech must be at least {{ limit }} characters in length.",
     *      maxMessage="The name of a BattleMech cannot be more than {{ limit }} characters in length."
     * )
     *
     * @JMS\Expose()
     */
    protected $chassisName;

    /**
     * @var string
     * @ORM\Column(name="chassis_designation", type="string", length=20)
     * @Assert\NotBlank(
     *      message="A BattleMech's designation cannot be blank."
     * )
     * @Assert\Length(
     *      min=5,
     *      max=40,
     *      minMessage="The designation of a BattleMech must be at least {{ limit }} characters in length.",
     *      maxMessage="The designation of a BattleMech cannot be more than {{ limit }} characters in length."
     * )
     *
     * @JMS\Expose()
     */
    protected $chassisDesignation;

    /**
     * @var integer
     * @ORM\Column(name="tonnage", type="integer")
     * @Assert\NotBlank(
     *      message="A BattleMech's tonnage cannot be blank."
     * )
     * @Assert\Range(
     *      min=20,
     *      max=100,
     *      minMessage="A BattleMech's tonnage cannot be less than {{ limit }} tons.",
     *      maxMessage="A BattleMech's tonnage cannot be more than {{ limit }} tons."
     * )
     *
     * @JMS\Expose()
     */
    protected $tonnage;

    /**
     * @var double
     * @ORM\Column(name="speed", type="decimal", precision=4, scale=2)
     * @Assert\NotBlank(
     *      message="A BattleMech's speed cannot be blank."
     * )
     *
     * @JMS\Expose()
     */
    protected $speed;

    /**
     * @var string
     * @ORM\Column(name="engine_type", type="string", length=10)
     * @Assert\NotBlank(
     *      message="A BattleMech's engine type cannot be blank."
     * )
     * @Assert\Length(
     *      max=10,
     *      maxMessage="A Battlemech's engine type must be less than {{ limit }} characters."
     * )
     *
     * @JMS\Expose()
     */
    protected $engineType;

    /**
     * @var integer
     * @ORM\Column(name="engine_rating", type="integer")
     * @Assert\NotBlank(
     *      message="A BattleMech's engine rating cannot be blank."
     * )
     * @Assert\Range(
     *      min=60,
     *      max=400,
     *      minMessage="A BattleMech's engine rating cannot be less than {{ limit }}.",
     *      maxMessage="A BattleMech's engine rating cannot be more than {{ limit }}."
     * )
     *
     * @JMS\Expose()
     */
    protected $engineRating;

    /**
     * @var string
     * @ORM\Column(name="tech_base", type="string", length=20)
     * @Assert\NotBlank(
     *      message="A BattleMech's technology base cannot be blank."
     * )
     * @Assert\Length(
     *      max=20,
     *      maxMessage="A Battlemech's technology base must be less than {{ limit }} characters."
     * )
     * @JMS\Expose()
     */
    protected $techBase;

    /**
     * @var string
     * @ORM\Column(name="internal_structure_type", type="string", length=20)
     * @Assert\NotBlank(
     *      message="A BattleMech's internal structure type cannot be blank."
     * )
     * @Assert\Length(
     *      max=20,
     *      maxMessage="A Battlemech's internal structure type must be less than {{ limit }} characters."
     * )
     *
     * @JMS\Expose()
     */
    protected $internalStructureType;

    /**
     * @var string
     * @ORM\Column(name="armor_base", type="string", length=20)
     * @Assert\NotBlank(
     *      message="A BattleMech's armor type cannot be blank."
     * )
     * @Assert\Length(
     *      max=20,
     *      maxMessage="A Battlemech's armor type must be less than {{ limit }} characters."
     * )
     *
     * @JMS\Expose()
     */
    protected $armorType;

    /**
     * @var string
     * @ORM\Column(name="heatsink_type", type="string", length=10)
     * @Assert\NotBlank(
     *      message="A BattleMech's heatsink type cannot be blank."
     * )
     * @Assert\Length(
     *      max=10,
     *      maxMessage="A Battlemech's heatsink type must be less than {{ limit }} characters."
     * )
     *
     * @JMS\Expose()
     */
    protected $heatSinkType;

    /**
     * @var string
     * @ORM\Column(name="image", type="string", nullable=true)
     *
     * @JMS\Expose()
     */
    protected $image;

//    protected $weapons;
//
//    protected $equipment;
}