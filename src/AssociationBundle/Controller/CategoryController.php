<?php

namespace AssociationBundle\Controller;

use AssociationBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Category controller.
 */
class CategoryController extends Controller
{
    /**
     * Lists all category entities.
     *
     * @Route(path="/category", name="category_index",methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('AssociationBundle:Category')->findAll();

        return $this->render('@Association/front/category/index.html.twig', array(
            'categories' => $categories,
        ));
    }



    /**
     * Finds and displays a category entity.
     *
     * @Route(path="/category/{id}", name="category_show",methods={"GET"})
     */
    public function showAction(Category $category)
    {
        $associations = $this->getDoctrine()->getRepository('AssociationBundle:Association')->findBy(array('domaine'=>$category));
        $missions = $this->getDoctrine()->getRepository('MissionBundle:Mission')->findBy(array('domaine'=>$category));
        //
        return $this->render('@Association/front/category/show.html.twig', array(
            'associations' => $associations,
            'missions' => $missions,
            'category' => $category,
        ));
    }





}
