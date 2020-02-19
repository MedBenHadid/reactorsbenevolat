<?php

namespace ReclamationBundle\Controller;

use ReclamationBundle\Entity\Requete;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Requete controller.
 *
 */
class RequeteController extends Controller
{
    /**
     * Lists all requete entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $requetes = $em->getRepository('ReclamationBundle:Requete')->findAll();

        return $this->render('@Reclamation/requete/index.html.twig', array(
            'requetes' => $requetes,
        ));
    }

    /**
     * Creates a new requete entity.
     * @IsGranted("ROLE_USER")
     */
    public function newAction(Request $request)
    {
        $requete = new Requete();
        $form = $this->createForm('ReclamationBundle\Form\RequeteType', $requete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $requete->setDernierMAJ(new \DateTime());
            $requete->setStatut(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($requete);
            $em->flush();

            return $this->redirectToRoute('requete_show', array('id' => $requete->getId()));
        }

        return $this->render('@Reclamation/requete/new.html.twig', array(
            'requete' => $requete,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a requete entity.
     *
     */
    public function showAction(Requete $requete)
    {
        $deleteForm = $this->createDeleteForm($requete);

        return $this->render('@Reclamation/requete/show.html.twig', array(
            'requete' => $requete,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing requete entity.
     *
     */
    public function editAction(Request $request, Requete $requete)
    {
        $deleteForm = $this->createDeleteForm($requete);
        $editForm = $this->createForm('ReclamationBundle\Form\RequeteType', $requete);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('requete_edit', array('id' => $requete->getId()));
        }

        return $this->render('@Reclamation/requete/edit.html.twig', array(
            'requete' => $requete,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a requete entity.
     *
     */
    public function deleteAction(Request $request, Requete $requete)
    {
        $form = $this->createDeleteForm($requete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($requete);
            $em->flush();
        }

        return $this->redirectToRoute('requete_index');
    }

    /**
     * Creates a form to delete a requete entity.
     *
     * @param Requete $requete The requete entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Requete $requete)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('requete_delete', array('id' => $requete->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
