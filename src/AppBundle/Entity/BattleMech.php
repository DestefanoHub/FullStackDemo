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
     * @JMS\Groups({"default", "mech-stub", "mech"})
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
     * @JMS\Groups({"default", "mech-stub", "mech"})
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
     * @JMS\Groups({"default", "mech-stub", "mech"})
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
     * @JMS\Groups({"default", "mech-stub", "mech"})
     */
    protected $tonnage;

    /**
     * @var Engine
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Engine")
     * @ORM\JoinTable(name="battlemech_engines",
     *      joinColumns={@ORM\JoinColumn(name="battlemech_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="engine_id", referencedColumnName="id")}
     * )
     * @Assert\Type(
     *      type="AppBundle\Entity\Engine",
     *      message="Not a valid engine."
     * )
     * @Assert\Valid()
     *
     * @JMS\Expose()
     * @JMS\Groups({"default", "mech"})
     */
    protected $engine;

    /**
     * @var double
     * @ORM\Column(name="speed", type="decimal", precision=5, scale=2)
     * @Assert\NotBlank(
     *      message="A BattleMech's speed cannot be blank."
     * )
     *
     * @JMS\Expose()
     * @JMS\Groups({"default", "mech"})
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
     *
     * @JMS\Expose()
     * @JMS\Groups({"default", "mech-stub", "mech"})
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
     * @JMS\Groups({"default", "mech"})
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
     * @JMS\Groups({"default", "mech"})
     */
    protected $armorType;

    /**
     * @var integer
     * @ORM\Column(name="cost", type="integer")
     * @Assert\NotBlank(
     *      message="A BattleMech's cost cannot be blank."
     * )
     *
     * @JMS\Expose()
     * @JMS\Groups({"default", "mech-stub", "mech"})
     */
    protected $cost;

    /**
     * @var integer
     * @ORM\Column(name="stock", type="integer")
     * @Assert\NotBlank(
     *     message="The number of a BattleMech in stock cannot be blank."
     * )
     *
     * @JMS\Expose()
     * @JMS\Groups({"default", "mech-stub", "mech"})
     */
    protected $stock;

    /**
     * @var string
     * @ORM\Column(name="image", type="string", nullable=true)
     *
     * @JMS\Expose()
     * @JMS\Groups({"default", "mech-stub", "mech"})
     */
    protected $image;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\MountedWeapons", mappedBy="battlemech", orphanRemoval=true, cascade={"all"})
     *
     * @JMS\Expose()
     */
    protected $weapons;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\MountedEquipment", mappedBy="battlemech", orphanRemoval=true, cascade={"all"})
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

    public function setWeight($tonnage)
    {
       $this->tonnage = $tonnage;
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

    /**
     * This should be determined in the controller by the Mech's weight and the engine rating. DO NOT set this manually!
     * @param $speed
     */
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
        $this->techBase = strtoupper($techBase);
    }

    public function getStructureType()
    {
        return $this->internalStructureType;
    }

    public function setStructureType($structure)
    {
        $this->internalStructureType = strtoupper($structure);
    }

    public function getArmorType()
    {
        return $this->armorType;
    }

    public function setArmorType($armor)
    {
        $this->armorType = strtoupper($armor);
    }

    public function getCost()
    {
        return $this->cost;
    }

    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getWeapons()
    {
        return $this->weapons;
    }

    public function addWeapon(MountedWeapons $weapon)
    {
        if($this->weapons->contains($weapon)){
            return false;
        } else{
            $this->weapons->add($weapon);
            $weapon->setBattleMech($this);
            return true;
        }
    }

    public function removeWeapon(MountedWeapons $weapon)
    {
        if($this->weapons->contains($weapon)){
            $this->weapons->removeElement($weapon);
            $weapon->setBattleMech(null);
            return true;
        } else{
            return false;
        }
    }

    public function getEquipment()
    {
        return $this->equipment;
    }

    public function addEquipment(MountedEquipment $equipment)
    {
        if($this->weapons->contains($equipment)){
            return false;
        } else{
            $this->equipment->add($equipment);
            $equipment->setBattleMech($this);
            return true;
        }
    }

    public function removeEquipment(MountedEquipment $equipment)
    {
        if($this->equipment->contains($equipment)){
            $this->equipment->removeElement($equipment);
            $equipment->setBattleMech(null);
            return true;
        } else{
            return false;
        }
    }
}