<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 7/7/16
 * Time: 5:49 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;

/**
 * Class Weapon
 * @package AppBundle\Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repositories\WeaponRepo")
 * @ORM\Table(name="weapons")
 * @ORM\HasLifecycleCallbacks()
 *
 * @JMS\ExclusionPolicy("all")
 */
class Weapon
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
     * @ORM\Column(name="name", type="string", length=40)
     * @Assert\NotBlank(
     *      message="A Weapon's name cannot be blank."
     * )
     * @Assert\Length(
     *      min=5,
     *      max=40,
     *      minMessage="The name of a Weapon must be at least {{ limit }} characters in length.",
     *      maxMessage="The name of a Weapon cannot be more than {{ limit }} characters in length."
     * )
     *
     * @JMS\Expose()
     */
    protected $name;

    /**
     * @var double
     * @ORM\Column(name="tonnage", type="decimal", precision=4, scale=2)
     * @Assert\NotBlank(
     *      message="A Weapon's tonnage cannot be blank."
     * )
     * @Assert\Range(
     *      min=0.25,
     *      minMessage="A Weapon's tonnage cannot be less than {{ limit }} tons."
     * )
     *
     * @JMS\Expose()
     */
    protected $tonnage;

    /**
     * @var string
     * @ORM\Column(name="type", type="string", length=20)
     * @Assert\NotBlank(
     *      message="A Weapon's armor type cannot be blank."
     * )
     * @Assert\Length(
     *      max=20,
     *      maxMessage="A Weapon's armor type must be less than {{ limit }} characters."
     * )
     *
     * @JMS\Expose()
     */
    protected $type;

    /**
     * @var string
     * @ORM\Column(name="tech_base", type="string", length=20)
     * @Assert\NotBlank(
     *      message="A Weapon's technology base cannot be blank."
     * )
     * @Assert\Length(
     *      max=20,
     *      maxMessage="A Weapon's technology base must be less than {{ limit }} characters."
     * )
     *
     * @JMS\Expose()
     */
    protected $techBase;

    public function __construct()
    {

    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getWeight()
    {
        return $this->tonnage;
    }

    public function setWeight($tonnage)
    {
        $this->tonnage = $tonnage;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getTechBase()
    {
        return $this->techBase;
    }

    public function setTechBase($techBase)
    {
        $this->name = $techBase;
    }
}