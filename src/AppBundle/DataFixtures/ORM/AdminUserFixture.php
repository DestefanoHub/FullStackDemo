<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 7/19/16
 * Time: 11:29 AM
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AdminUserFixture implements FixtureInterface, ContainerAwareInterface
{
    private $container;

    /**
     * @param ObjectManager $om
     */
    public function load(ObjectManager $om)
    {
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->container->get('fos_user.user_manager');
        $userAdmin = $userManager->createUser();
        $userAdmin->setUsername("sysadmin")
            ->setEmail("temp@fakemail.com")
            ->setPlainPassword("securepassword")
            ->addRole("ADMIN")
            ->setEnabled(true);

        $userManager->updateUser($userAdmin);
        $om->flush();
    }

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}