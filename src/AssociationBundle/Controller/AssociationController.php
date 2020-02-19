<?php

namespace AssociationBundle\Controller;

use AppBundle\Entity\User;
use AssociationBundle\Entity\Association;
use http\Env\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Association controller.
 *
 * @Route("/association")
 */
class AssociationController extends Controller
{
    /**
     * @Route("/", name="association_index",methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $associations = $em->getRepository('AssociationBundle:Association')->findAll();

        return $this->render('@Association/association/index.html.twig', array(
            'associations' => $associations,
        ));
    }

    /**
     * @Route("/{id}", name="association_show",methods={"GET"})
     */
    public function showAction(Association $association)
    {
        $deleteForm = $this->createDeleteForm($association);

        return $this->render('@Association/association/show.html.twig', array(
            'association' => $association,
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
