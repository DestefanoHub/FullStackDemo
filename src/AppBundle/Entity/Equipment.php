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
 * Class Equipment
 * @package AppBundle\Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repositories\EquipmentRepo")
 * @ORM\Table(name="equipment")
 * @ORM\HasLifecycleCallbacks()
 *
 * @JMS\ExclusionPolicy("all")
 */
class Equipment
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @JMS\Expose()
     * @JMS\Groups({"default", "equipment"})
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
     * @JMS\Groups({"default", "equipment"})
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
     * @JMS\Groups({"equipment"})
     */
    protected $tonnage;

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
     * @JMS\Groups({"equipment"})
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

    public function getTechBase()
    {
        return $this->techBase;
    }

    public function setTechBase($techBase)
    {
        $this->techBase = strtoupper($techBase);
    }
}