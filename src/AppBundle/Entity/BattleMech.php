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
}