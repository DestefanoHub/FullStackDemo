<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 7/5/16
 * Time: 4:50 PM
 */

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;

/**
 * Class User
 * @package AppBundle\Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repositories\UserRepo")
 * @ORM\Table(name="isms_users")
 * @ORM\HasLifecycleCallbacks()
 *
 * @JMS\ExclusionPolicy("all")
 */
class User extends BaseUser
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
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime")
     *
     * @JMS\Expose()
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="modified_at", type="datetime", nullable=true)
     *
     * @JMS\Expose()
     */
    protected $modifiedAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     *
     * @JMS\Expose()
     */
    protected $deletedAt;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Update the creation time on CREATE ONLY
     * @ORM\PrePersist
     */
    public function setCreatedAt()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Update the modified at value on all fields on these events.
     * @ORM\PreUpdate
     */
    public function setModifiedAt()
    {
        $this->modifiedAt = new \DateTime();
    }

    /**
     * Get modifiedAt
     *
     * @return \DateTime
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * @param \DateTime $deletedAt
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}