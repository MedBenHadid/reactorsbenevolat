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
 * @Route("/dashboard/admin/association")
 *
 */
class SuperAdminController extends Controller
{
    /**
     * @Route("/", name="admin_association_index",methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $associations = $em->getRepository('AssociationBundle:Association')->findAll();

        return $this->render('@Association/association/admin/index.html.twig', array(
            'associations' => $associations,
        ));
    }

    /**
     * @Route("/new", name="admin_association_new",methods={"GET","POST"})
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function newAction(Request $request)
    {
        $association = new Association();
        $form = $this->createForm('AssociationBundle\Form\AssociationType', $association);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($association);
            $em->flush();

            return $this->redirectToRoute('association_show', array('id' => $association->getId()));
        }

        return $this->render('@Association/association/new.html.twig', array(
            'association' => $association,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}", name="admin_association_show",methods={"GET"})
     */
    public function showAction(Association $association)
    {
        $deleteForm = $this->createDeleteForm($association);

        return $this->render('@Association/association/admin/show.html.twig', array(
            'association' => $association
        ));
    }


    /**
     * @IsGranted("ROLE_SUPER_ADMIN")
     * @Route("/{id}/edit", name="admin_association_edit",methods={"GET","POST"})
     */
    public function editAction(Request $request, Association $association)
    {
        $deleteForm = $this->createDeleteForm($association);
        $editForm = $this->createForm('AssociationBundle\Form\AssociationType', $association);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('association_edit', array('id' => $association->getId()));
        }

        return $this->render('@Association/association/edit.html.twig', array(
            'association' => $association,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/{id}", name="admin_association_delete",methods={"DELETE"})
     */
    public function deleteAction(Request $request, Association $association)
    {
        $form = $this->createDeleteForm($association);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($association);
            $em->flush();
        }

        return $this->redirectToRoute('association_index');
    }

    /**
     * Creates a form to delete a association entity.
     *
     * @param Association $association The association entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Association $association)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_association_delete', array('id' => $association->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
