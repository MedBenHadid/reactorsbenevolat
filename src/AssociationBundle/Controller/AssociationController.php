<?php

namespace AssociationBundle\Controller;

use AssociationBundle\Entity\Association;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Association controller.
 *
 * @Route("/association")
 */
class AssociationController extends Controller
{
    /**
     * @Route(path="/", name="association_index",methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $associations = $em->getRepository('AssociationBundle:Association')->findAll();

        return $this->render('@Association/front/association/index.html.twig', array(
            'associations' => $associations,
        ));
    }

    /**
     * @Route(path="/{id}", name="association_show",methods={"GET"})
     */
    public function showAction(Association $association)
    {
        return $this->render('@Association/front/association/show.html.twig', array(
            'association' => $association
        ));
    }
}
