<?php

namespace RefugeeBundle\Controller;

use RefugeeBundle\Entity\Refugee;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
     * Creates a new refugee entity.
     *
     */
    public function newAction(Request $request)
    {
        $refugee = new Refugee();
        $form = $this->createForm('RefugeeBundle\Form\RefugeeType', $refugee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($refugee);
            $em->flush();

            return $this->redirectToRoute('refugee_show', array('id' => $refugee->getId()));
        }

        return $this->render('refugee/new.html.twig', array(
            'refugee' => $refugee,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a refugee entity.
     *
     */
    public function showAction(Refugee $refugee)
    {
        $deleteForm = $this->createDeleteForm($refugee);

        return $this->render('refugee/show.html.twig', array(
            'refugee' => $refugee,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing refugee entity.
     *
     */
    public function editAction(Request $request, Refugee $refugee)
    {
        $deleteForm = $this->createDeleteForm($refugee);
        $editForm = $this->createForm('RefugeeBundle\Form\RefugeeType', $refugee);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('refugee_edit', array('id' => $refugee->getId()));
        }

        return $this->render('refugee/edit.html.twig', array(
            'refugee' => $refugee,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a refugee entity.
     *
     */
    public function deleteAction(Request $request, Refugee $refugee)
    {
        $form = $this->createDeleteForm($refugee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($refugee);
            $em->flush();
        }

        return $this->redirectToRoute('refugee_index');
    }

    /**
     * Creates a form to delete a refugee entity.
     *
     * @param Refugee $refugee The refugee entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Refugee $refugee)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('refugee_delete', array('id' => $refugee->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
