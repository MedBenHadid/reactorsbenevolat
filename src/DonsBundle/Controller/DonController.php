<?php

namespace DonsBundle\Controller;

use DonsBundle\Entity\Don;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Don controller.
 *
 */
class DonController extends Controller
{
    /**
     * Lists all don entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $dons = $em->getRepository('DonsBundle:Don')->findAll();

        return $this->render('don/index.html.twig', array(
            'dons' => $dons,
        ));
    }

    /**
     * Creates a new don entity.
     *
     */
    public function newAction(Request $request)
    {
        $don = new Don();
        $form = $this->createForm('DonsBundle\Form\DonType', $don);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($don);
            $em->flush();

            return $this->redirectToRoute('don_show', array('id' => $don->getId()));
        }

        return $this->render('don/new.html.twig', array(
            'don' => $don,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a don entity.
     *
     */
    public function showAction(Don $don)
    {
        $deleteForm = $this->createDeleteForm($don);

        return $this->render('don/show.html.twig', array(
            'don' => $don,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing don entity.
     *
     */
    public function editAction(Request $request, Don $don)
    {
        $deleteForm = $this->createDeleteForm($don);
        $editForm = $this->createForm('DonsBundle\Form\DonType', $don);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('don_edit', array('id' => $don->getId()));
        }

        return $this->render('don/edit.html.twig', array(
            'don' => $don,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a don entity.
     *
     */
    public function deleteAction(Request $request, Don $don)
    {
        $form = $this->createDeleteForm($don);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($don);
            $em->flush();
        }

        return $this->redirectToRoute('don_index');
    }

    /**
     * Creates a form to delete a don entity.
     *
     * @param Don $don The don entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Don $don)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('don_delete', array('id' => $don->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
