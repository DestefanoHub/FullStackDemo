<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 7/10/16
 * Time: 8:46 PM
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;

/**
 * Class Order
 * @package AppBundle\Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repositories\OrderRepo")
 * @ORM\Table(name="orders")
 * @ORM\HasLifecycleCallbacks()
 *
 * @JMS\ExclusionPolicy("all")
 */
class Order
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
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="orders")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    protected $use;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\BattleMech")
     * @ORM\JoinTable(name="ordered_battlemechs",
     *      joinColumns={@ORM\JoinColumn(name="order_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns{@ORM\JoinColumn(name="battlemech_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    protected $items;
}