<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 7/7/16
 * Time: 11:49 AM
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\Column(name="chassis_variant", type="string", length=20)
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
    protected $chassisVariant;

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
     * @var Engine
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Engine", cascade={"all"})
     * @ORM\JoinColumn(name="engine_id", referencedColumnName="id")
     * @Assert\Type(
     *      type="AppBundle\Entity\Engine",
     *      message="Not a valid engine."
     * )
     * @Assert\Valid()
     *
     * @JMS\Expose()
     */
    protected $engine;

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

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\MountedWeapons", cascade={"all"})
     *
     * @JMS\Expose()
     */
    protected $weapons;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\MountedEquipment", cascade={"all"})
     *
     * @JMS\Expose()
     */
    protected $equipment;

    public function __construct()
    {
        $this->weapons = new ArrayCollection();
        $this->equipment = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->chassisName;
    }

    public function setName($name)
    {
        $this->chassisName = $name;
    }

    public function getVariant()
    {
        return $this->chassisVariant;
    }

    public function setVariant($variant)
    {
        $this->chassisVariant = strtoupper($variant);
    }

    public function getWeight()
    {
        return $this->tonnage;
    }

    public function setWeight($weight)
    {
        //Weight must be in 5 ton increments
        if(($weight % 5) != 0){
            return "The weight must be a multiple of 5 tons.";
        } else{
            $this->tonnage = $weight;
            return true;
        }
    }

    public function getEngine()
    {
        return $this->engine;
    }

    public function setEngine($engine)
    {
        $this->engine = $engine;
    }

    public function getSpeed()
    {
        return $this->speed;
    }

    public function setSpeed($speed)
    {
        $this->speed = $speed;
    }

    public function getTechBase()
    {
        return $this->techBase;
    }

    public function setTechBase($techBase)
    {
        $caseTechBAse = strtoupper($techBase);
        //Only allow proper technology bases
        if($caseTechBAse != "INNER SPHERE" || $caseTechBAse != "CLAN"){
            return "The technology base must either be INNER SPHERE or CLAN.";
        } else{
            $this->techBase = $caseTechBAse;
            return true;
        }
    }

    public function getStructureType()
    {
        return $this->internalStructureType;
    }

    public function setStructureType($structure)
    {
        $caseStructure = strtoupper($structure);
        //Only allow proper structure types
        if($caseStructure != "ENDO-STEEL" || $caseStructure != "STANDARD"){
            return "The internal structure must either be a STANDARD or ENDO-STEEL.";
        } else{
            $this->internalStructureType = $caseStructure;
            return true;
        }
    }

    public function getArmorType()
    {
        return $this->armorType;
    }

    public function setArmorType($armor)
    {
        $caseArmor = strtoupper($armor);
        //Only allow proper armor types
        if($caseArmor != "FERRO-FIBROUS" || $caseArmor != "STANDARD"){
            return "The armor must either be a STANDARD or FERRO-FIBROUS.";
        } else{
            $this->armorType = $caseArmor;
            return true;
        }
    }

    public function getHeatSinkType()
    {
        return $this->heatSinkType;
    }

    public function setHeatSinkType($heatSink)
    {
        $caseHeatSink = strtoupper($heatSink);
        //Only allow proper heatsink types
        if($caseHeatSink != "DOUBLE" || $caseHeatSink != "SINGLE"){
            return "The heat sinks must either be a SINGLE or DOUBLE.";
        } else{
            $this->heatSinkType = $caseHeatSink;
            return true;
        }
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }
}