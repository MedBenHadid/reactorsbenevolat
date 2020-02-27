<?php
namespace AssociationBundle\DataFixtures;

use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use FOS\UserBundle\Model\UserManagerInterface;
class UsersFixture extends Fixture
{


    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('user');
        $user->setApprouved(true);
        $user->setEmail('user@reactors.tn');
        $user->setEnabled(true);
        $user->setPlainPassword('1ac2620f');
        $user->setRoles(array("ROLE_CLIENT"));
        $user->setNom('Chihab');
        $user->setPrenom('Hajji');
        $manager->persist($user);
        $manager->flush();
    }
}