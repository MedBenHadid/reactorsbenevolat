<?php

namespace ReclamationBundle\Controller;

use ReclamationBundle\Entity\Rponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Rponse controller.
 *
 */
class RponseController extends Controller
{
    /**
     * Lists all rponse entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $rponses = $em->getRepository('ReclamationBundle:Rponse')->findAll();

        return $this->render('@Reclamation/rponse/index.html.twig', array(
            'rponses' => $rponses,
        ));
    }

    /**
     * Creates a new rponse entity.
     *
     */
    public function newAction(Request $request)
    {
        $rponse = new Rponse();
        $form = $this->createForm('ReclamationBundle\Form\RponseType', $rponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rponse);
            $em->flush();

            return $this->redirectToRoute('rponse_show', array('id' => $rponse->getId()));
        }

        return $this->render('@Reclamation/rponse/new.html.twig', array(
            'rponse' => $rponse,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a rponse entity.
     *
     */
    public function showAction(Rponse $rponse)
    {
        $deleteForm = $this->createDeleteForm($rponse);

        return $this->render('@Reclamation/rponse/show.html.twig', array(
            'rponse' => $rponse,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing rponse entity.
     *
     */
    public function editAction(Request $request, Rponse $rponse)
    {
        $deleteForm = $this->createDeleteForm($rponse);
        $editForm = $this->createForm('ReclamationBundle\Form\RponseType', $rponse);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rponse_edit', array('id' => $rponse->getId()));
        }

        return $this->render('@Reclamation/rponse/edit.html.twig', array(
            'rponse' => $rponse,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a rponse entity.
     *
     */
    public function deleteAction(Request $request, Rponse $rponse)
    {
        $form = $this->createDeleteForm($rponse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($rponse);
            $em->flush();
        }

        return $this->redirectToRoute('rponse_index');
    }

    /**
     * Creates a form to delete a rponse entity.
     *
     * @param Rponse $rponse The rponse entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Rponse $rponse)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('rponse_delete', array('id' => $rponse->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
