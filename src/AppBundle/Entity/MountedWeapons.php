<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 7/7/16
 * Time: 6:16 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;

/**
 * Class MountedWeapons
 * @package AppBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="mounted_weapons")
 */
class MountedWeapons
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
     * @var integer
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BattleMech", inversedBy="weapons", cascade={"all"})
     * @ORM\JoinColumn(name="battlemech_id", referencedColumnName="id", nullable=false)
     */
    protected $battlemech;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Weapon")
     * @ORM\JoinColumn(name="weapon_id", referencedColumnName="id", nullable=false)
     */
    protected $weapon;

    /**
     * @var integer
     * @ORM\Column(name="number_equipped", type="integer")
     * @Assert\NotBlank(
     *      message="At least one of a weapon must be equipped."
     * )
     * @Assert\Range(
     *      min=1,
     *      minMessage="At least one of a weapon must be equipped."
     * )
     */
    protected $numberEquipped;

    public function __construct()
    {

    }

    public function getId()
    {
        return $this->id;
    }

    public function getBattleMech()
    {
        return $this->battlemech;
    }

    public function setBattleMech(BattleMech $battlemech)
    {
        $this->battlemech = $battlemech;
    }

    public function getWeapon()
    {
        return $this->weapon;
    }

    public function setWeapon(Weapon $weapon)
    {
        $this->weapon = $weapon;
    }

    public function getNumberEquipped()
    {
        return $this->numberEquipped;
    }

    public function setNumberEquipped($numberEquipped)
    {
        $this->numberEquipped = $numberEquipped;
    }
}