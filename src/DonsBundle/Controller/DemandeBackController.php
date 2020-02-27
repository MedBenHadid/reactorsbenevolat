<?php

namespace DonsBundle\Controller;

use DonsBundle\Entity\Demande;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Demande controller.
 *
 */
class DemandeBackController extends Controller
{
    /**
     * Lists all demande entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // $demandes = $em->getRepository('DonsBundle:Demande')->findAll();
        $dql = "SELECT de FROM DonsBundle:Demande de" ;
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $result =  $paginator->paginate($query ,
            $request->query->getInt('page' , 1)  ,
            $request->query->getInt('limit ' , 2));

        return $this->render('demande/index.html.twig', array(
            'demandes' => $result,
        ));
    }

    /**
     * Creates a new demande entity.
     *
     */
    public function newAction(Request $request)
    {

        $demande = new Demande();
        $form = $this->createForm('DonsBundle\Form\DemandeType', $demande);
        $form->add('user' )->add('creationDate');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            var_dump($request->request->get('lat_don'));
            $demande->setLatitude($request->request->get('lat_demande'));
            $demande->setLongitude($request->request->get('lng_demande'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($demande);
            $em->flush();


            return $this->redirectToRoute('demande_show', array('id' => $demande->getId()));
        }

        return $this->render('demande/new.html.twig', array(
            'demande' => $demande,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a demande entity.
     *
     */
    public function showAction(Demande $demande)
    {
        $deleteForm = $this->createDeleteForm($demande);

        return $this->render('demande/show.html.twig', array(
            'demande' => $demande,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing demande entity.
     *
     */
    public function editAction(Request $request, Demande $demande)
    {
        $deleteForm = $this->createDeleteForm($demande);
        $editForm = $this->createForm('DonsBundle\Form\DemandeType', $demande);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('demande_edit', array('id' => $demande->getId()));
        }

        return $this->render('demande/edit.html.twig', array(
            'demande' => $demande,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a demande entity.
     *
     */
    public function deleteAction(Request $request, Demande $demande)
    {
        $form = $this->createDeleteForm($demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($demande);
            $em->flush();
        }

        return $this->redirectToRoute('demande_index');
    }

    /**
     * Creates a form to delete a demande entity.
     *
     * @param Demande $demande The demande entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Demande $demande)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('demande_delete', array('id' => $demande->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
