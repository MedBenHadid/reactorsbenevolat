<?php

namespace AssociationBundle\Controller;

use AssociationBundle\Entity\Association;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * SuperAdmin controller.
 *
 * @Route("/dashboard/manager/association")
 * @IsGranted("ROLE_ASSOCIATION_ADMIN")
 */
class AssociationAdminController extends Controller
{
    // TO:DO : jiblou association mté3ou
    /**
     * @Route("/", name="manager_association_index",methods={"GET"})
     */
    public function indexAction()
    {
        $current = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array('username'=>$this->getUser()->getUsername()));
        $association = $this->getDoctrine()->getRepository('AssociationBundle:Association')->findOneBy(array('manager'=>$current));
        $em = $this->getDoctrine()->getManager();

        return $this->render('@Association/association/manager/index.html.twig', array(
            'association' => $association,
        ));
    }

    /**
     * @Route("/{id}", name="manager_association_show",methods={"GET"})
     */
    public function showAction(Association $association)
    {
        $deleteForm = $this->createDeleteForm($association);

        return $this->render('@Association/association/show.html.twig', array(
            'association' => $association,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    // TO:DO : Rodha bil id mté3ou
    /**
     * @Route("/{id}/edit", name="manager_association_edit",methods={"GET","POST"})
     */
    public function editAction(Request $request, Association $association)
    {
        $deleteForm = $this->createDeleteForm($association);
        $editForm = $this->createForm('AssociationBundle\Form\AssociationType', $association);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_association_edit', array('id' => $association->getId()));
        }

        return $this->render('@Association/association/edit.html.twig', array(
            'association' => $association,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
