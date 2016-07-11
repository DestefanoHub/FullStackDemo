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
 * Class MountedEquipment
 * @package AppBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="mounted_equipment")
 */
class MountedEquipment
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
     * @var BattleMech
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BattleMech", inversedBy="equipment", cascade={"all"})
     * @ORM\JoinColumn(name="battlemech_id", referencedColumnName="id", nullable=false)
     */
    protected $battlemech;

    /**
     * @var Equipment
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Equipment")
     * @ORM\JoinColumn(name="equipment_id", referencedColumnName="id", nullable=false)
     */
    protected $equipment;

    /**
     * @var integer
     * @ORM\Column(name="number_equipped", type="integer")
     * @Assert\NotBlank(
     *      message="At least one of a piece of equipment must be equipped."
     * )
     * @Assert\Range(
     *      min=1,
     *      minMessage="At least one of a piece of equipment must be equipped."
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

    public function getEquipment()
    {
        return $this->equipment;
    }

    public function setEquipment(Equipment $equipment)
    {
        $this->equipment = $equipment;
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