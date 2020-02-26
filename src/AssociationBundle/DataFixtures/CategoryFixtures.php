<?php

namespace AssociationBundle\DataFixtures;

use AssociationBundle\Entity\Category;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{
    public const SOCIAL_CATEGORY_REFERENCE = 'HUMAN';
    public function load(ObjectManager $manager)
    {
        $category = new Category();
        $category->setName("Environementale");
        $manager->persist($category);

        $category = new Category();
        $category->setName("Education");
        $manager->persist($category);

        $category = new Category();
        $category->setName("Benevolat");
        $manager->persist($category);

        $category = new Category();
        $category->setName("Humanitaire");
        $manager->persist($category);

        $manager->flush();
        $this->addReference(self::SOCIAL_CATEGORY_REFERENCE, $category);
    }
}
