<?php
namespace AssociationBundle\DataFixtures;

use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use FOS\UserBundle\Model\UserManagerInterface;
class AdminFixture extends Fixture
{


    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('adminuser1');
        $user->setEmail('admin@reactors.tn');
        $user->setEnabled(true);
        $user->setPlainPassword('1ac2620f');
        $user->addRole(array('ROLE_SUPER_ADMIN'));
        $manager->persist($user);
        $manager->flush();
    }
}