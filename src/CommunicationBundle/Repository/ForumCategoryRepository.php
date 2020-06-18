<?php

namespace CommunicationBundle\Repository;

/**
 * ForumCategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ForumCategoryRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByName($category_name)
    {
        $query = $this->getEntityManager()->createQueryBuilder();

        $query->select('categ.name')
            ->from('CommunicationBundle:ForumCategory', 'categ')
            ->where('categ.name = ' . ':name')
            ->setParameters(
                [
                    'name' => $category_name
                ]
            );

        return $query->getQuery()->getResult();
    }
}
