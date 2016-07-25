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
 * Class Engine
 * @package AppBundle\Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repositories\EngineRepo")
 * @ORM\Table(name="engines")
 * @ORM\HasLifecycleCallbacks()
 *
 * @JMS\ExclusionPolicy("all")
 */
class Engine
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @JMS\Expose()
     * @JMS\Groups({"default", "engine"})
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="tech_base", type="string", length=20)
     * @Assert\NotBlank(
     *      message="An engine's technology base cannot be blank."
     * )
     * @Assert\Length(
     *      max=20,
     *      maxMessage="An engine's technology base must be less than {{ limit }} characters."
     * )
     * @JMS\Expose()
     * @JMS\Groups({"default", "engine"})
     */
    protected $techBase;

    /**
     * @var string
     * @ORM\Column(name="engine_type", type="string", length=10)
     * @Assert\NotBlank(
     *      message="A BattleMech's engine type cannot be blank."
     * )
     * @Assert\Length(
     *      max=10,
     *      maxMessage="An engine's type must be less than {{ limit }} characters."
     * )
     *
     * @JMS\Expose()
     * @JMS\Groups({"default", "engine"})
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
     *      minMessage="An engine's rating cannot be less than {{ limit }}.",
     *      maxMessage="An engine's rating cannot be more than {{ limit }}."
     * )
     *
     * @JMS\Expose()
     * @JMS\Groups({"default", "engine"})
     */
    protected $engineRating;

    public function getId()
    {
        return $this->id;
    }

    public function getTechBase()
    {
        return $this->techBase;
    }

    public function setTechBase($techBase)
    {
        $this->techBase = strtoupper($techBase);
    }

    public function getEngineType()
    {
        return $this->engineType;
    }

    public function setEngineType($engine)
    {
        $this->engineType = strtoupper($engine);
    }

    public function getEngineRating()
    {
        return $this->engineRating;
    }

    public function setEngineRating($rating)
    {
        $this->engineRating = $rating;
    }
}