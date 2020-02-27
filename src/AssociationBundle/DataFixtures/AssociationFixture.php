<?php
namespace AssociationBundle\DataFixtures;

use AssociationBundle\Entity\Adherance;
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
        $user->setPrenom('Chihab');
        $user->setNom("Hajji");
        $user->setPlainPassword('1ac2620f');
        $user->addRole(User::ASSOCIATION_ADMIN);

        $manager->persist($user);
        $manager->flush();



        $assocition = new Association();
        $assocition->setNom("Enactus");
        $assocition->setManager($user);
        $assocition->setDomaine($this->getReference(CategoryFixtures::SOCIAL_CATEGORY_REFERENCE));
        $assocition->setApprouved(true);
        $assocition->setPhoto("enactus.jpeg");
        $assocition->setTelephone("71268147");
        $assocition->setHoraireTravail("8 vers 17");
        $assocition->setPieceJustificatif("enactus.docx");
        $assocition->setCodePostal("2000");

        $adherance = new Adherance();
        $adherance->setAssociation($assocition);
        $adherance->setUser($user);
        $adherance->setFonction('Fondateur');
        $adherance->setDescription('Fondée lassociation');

        $manager->persist($adherance);
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