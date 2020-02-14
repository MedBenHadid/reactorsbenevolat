<?php

namespace RefugeeBundle\Controller;

use RefugeeBundle\Entity\Refugee;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Refugee controller.
 *
 */
class RefugeeController extends Controller
{
    /**
     * Lists all refugee entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $refugees = $em->getRepository('RefugeeBundle:Refugee')->findAll();

        return $this->render('refugee/index.html.twig', array(
            'refugees' => $refugees,
        ));
    }

    /**
     * Finds and displays a refugee entity.
     *
     */
    public function showAction(Refugee $refugee)
    {

        return $this->render('refugee/show.html.twig', array(
            'refugee' => $refugee,
        ));
    }
}
