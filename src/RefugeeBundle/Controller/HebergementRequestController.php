<?php

namespace RefugeeBundle\Controller;

use RefugeeBundle\Entity\HebergementRequest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Hebergementrequest controller.
 *
 */
class HebergementRequestController extends Controller
{
    /**
     * Lists all hebergementRequest entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $hebergementRequests = $em->getRepository('RefugeeBundle:HebergementRequest')->findAll();

        return $this->render('@Refugee/HebergementRequest/index.html.twig', array(
            'hebergementRequests' => $hebergementRequests,
        ));
    }

    /**
     * Creates a new hebergementRequest entity.
     *
     */
    public function newAction(Request $request)
    {
        $hebergementRequest = new Hebergementrequest();
        $form = $this->createForm('RefugeeBundle\Form\HebergementRequestType', $hebergementRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($hebergementRequest);
            $em->flush();

            return $this->redirectToRoute('hebergementrequest_show', array('id' => $hebergementRequest->getId()));
        }

        return $this->render('Refugee/HebergementRequest/new.html.twig', array(
            'hebergementRequest' => $hebergementRequest,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a hebergementRequest entity.
     *
     */
    public function showAction(HebergementRequest $hebergementRequest)
    {
        $deleteForm = $this->createDeleteForm($hebergementRequest);

        return $this->render('Refugee/HebergementRequest/show.html.twig', array(
            'hebergementRequest' => $hebergementRequest,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing hebergementRequest entity.
     *
     */
    public function editAction(Request $request, HebergementRequest $hebergementRequest)
    {
        $deleteForm = $this->createDeleteForm($hebergementRequest);
        $editForm = $this->createForm('RefugeeBundle\Form\HebergementRequestType', $hebergementRequest);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('hebergementrequest_edit', array('id' => $hebergementRequest->getId()));
        }

        return $this->render('Refugee/HebergementRequest/edit.html.twig', array(
            'hebergementRequest' => $hebergementRequest,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a hebergementRequest entity.
     *
     */
    public function deleteAction(Request $request, HebergementRequest $hebergementRequest)
    {
        $form = $this->createDeleteForm($hebergementRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($hebergementRequest);
            $em->flush();
        }

        return $this->redirectToRoute('hebergementrequest_index');
    }

    /**
     * Creates a form to delete a hebergementRequest entity.
     *
     * @param HebergementRequest $hebergementRequest The hebergementRequest entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(HebergementRequest $hebergementRequest)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('hebergementrequest_delete', array('id' => $hebergementRequest->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
