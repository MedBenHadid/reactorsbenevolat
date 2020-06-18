<?php

namespace MissionBundle\Controller;

use MissionBundle\Entity\Invitation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Invitation controller.
 *
 * @Route("invitation")
 */
class InvitationController extends Controller
{
    /**
     * Lists all invitation entities.
     *
     * @Route("/", name="Invitation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $invitations = $em->getRepository('MissionBundle:Invitation')->findAll();

        return $this->render('@Mission/invitation/index.html.twig', array(
            'invitations' => $invitations,
        ));
    }

    /**
     * Creates a new invitation entity.
     *
     * @Route("/new", name="Invitation_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $invitation = new Invitation();
        $form = $this->createForm('MissionBundle\Form\InvitationType', $invitation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($invitation);
            $em->flush();

            return $this->redirectToRoute('Invitation_show', array('id' => $invitation->getId()));
        }

        return $this->render('@Mission/invitation/new.html.twig', array(
            'invitation' => $invitation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a invitation entity.
     *
     * @Route("/{id}", name="Invitation_show")
     * @Method("GET")
     */
    public function showAction(Invitation $invitation)
    {
        $deleteForm = $this->createDeleteForm($invitation);

        return $this->render('@Mission/invitation/show.html.twig', array(
            'invitation' => $invitation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing invitation entity.
     *
     * @Route("/{id}/edit", name="Invitation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Invitation $invitation)
    {
        $deleteForm = $this->createDeleteForm($invitation);
        $editForm = $this->createForm('MissionBundle\Form\InvitationType', $invitation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('Invitation_edit', array('id' => $invitation->getId()));
        }

        return $this->render('@Mission/invitation/edit.html.twig', array(
            'invitation' => $invitation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a invitation entity.
     *
     * @Route("/{id}", name="Invitation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Invitation $invitation)
    {
        $form = $this->createDeleteForm($invitation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($invitation);
            $em->flush();
        }

        return $this->redirectToRoute('Invitation_index');
    }

    /**
     * Creates a form to delete a invitation entity.
     *
     * @param Invitation $invitation The invitation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Invitation $invitation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('Invitation_delete', array('id' => $invitation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
