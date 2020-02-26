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
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $twig = '@Refugee/HebergementRequest/index.html.twig';

        if (!in_array("ROLE_SUPER_ADMIN", $this->getUser()->getRoles()))
        {
            $twig = '@Refugee/front/HebergementRequest/index.html.twig';
        }

        $governorat = $request->request->get('governorat') ? $request->request->get('governorat') : null;
        $nbrRooms = $request->request->get('nbrRooms') ? $request->request->get('nbrRooms') : null;
        $duration = $request->request->get('duration') ? $request->request->get('duration') : null;

        //die(var_dump($governorat));

        $hebergementRequests = $em->getRepository('RefugeeBundle:HebergementRequest')->findAll();

        $paginator = $this->get('knp_paginator');
        $hebergementRequests =  $paginator->paginate($hebergementRequests ,
            $request->query->getInt('page' , 1)  ,
            $request->query->getInt('limit ' , 6));

        return $this->render($twig, array(
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
        $twig = '@Refugee/HebergementRequest/new.html.twig';

        if (!in_array("ROLE_SUPER_ADMIN", $this->getUser()->getRoles()))
        {
            $twig = '@Refugee/front/HebergementRequest/new.html.twig';
        }


        $form = $this->createForm('RefugeeBundle\Form\HebergementRequestType', $hebergementRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $childrenNumber = $form->get('childrenNumber')->getData();
            $passportNumber = $form->get('passportNumber')->getData();

            if ($childrenNumber <= 0 || $passportNumber <= 0)
            {
                return $this->render($twig, array(
                    'hebergement' => $hebergementRequest,
                    'form' => $form->createView(),
                    'error' => 'valeurs invalides'
                ));
            }


            $em = $this->getDoctrine()->getManager();

            $hebergementRequest->setCreationDate(new \DateTime());
            $hebergementRequest->setState(0);
            $userId = $this->getUser()->getId();
            $user = $em->getRepository('AppBundle:User')->find($userId);
            $hebergementRequest->setUser($user);

            $em->persist($hebergementRequest);
            $em->flush();

            return $this->redirectToRoute('hebergementrequest_index');
        }

        return $this->render($twig, array(
            'hebergementRequest' => $hebergementRequest,
            'form' => $form->createView(),
            'error' => null
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
            'hebergementRequests' => $hebergementRequest,
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
