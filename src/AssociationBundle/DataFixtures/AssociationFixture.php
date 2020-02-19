<?php
namespace AssociationBundle\DataFixtures;

use AssociationBundle\Entity\Association;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AssociationFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('assadmin');
        $user->setEmail('admin@enactus.tn');
        $user->setEnabled(true);
        $user->setPrenom("Chihab");
        $user->setNom("Hajji");
        $user->setPlainPassword('1ac2620f');
        $user->addRole(array('ROLE_ASSOCIATION_ADMIN'));

        $manager->persist($user);
        $manager->flush();



        $assocition = new Association();
        $assocition->setNomAssociation("Enactus");
        $assocition->setManager($manager);
        $assocition->setDomaine($this->getReference(CategoryFixtures::SOCIAL_CATEGORY_REFERENCE));
        $assocition->setApprouved(true);
        $assocition->setPhotoAssociation("enactus.jpeg");
        $assocition->setTelephoneAssociation("71268147");
        $assocition->setHoraireTravail("8 vers 17");
        $assocition->setPieceJustificatif("enactus.docx");
        $assocition->setCodePostal("2000");

        $manager->persist($assocition);
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CategoryFixtures::class,
        );
    }
}