<?php

namespace RefugeeBundle\Controller;

use RefugeeBundle\Entity\Hebergement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Hebergement controller.
 *
 */
class HebergementController extends Controller
{
    public function searchAction(Request $request)
    {
        $governorat = $request->query->get('governorat') ? $request->query->get('governorat') : null;
        $nbrRooms = $request->query->get('nbrRooms') ? $request->query->get('nbrRooms') : null;
        $duration = $request->query->get('duration') ? $request->query->get('duration') : null;


        $hebergements = $this->getDoctrine()->getRepository('RefugeeBundle:Hebergement')
        ->search($governorat, $nbrRooms, $duration);


        $paginator = $this->get('knp_paginator');
        $hebergements =  $paginator->paginate($hebergements ,
            $request->query->getInt('page' , 1)  ,
            $request->query->getInt('limit ' , 6));

        return $this->render('@Refugee/front/Hebergement/index.html.twig', array(
            'hebergements' => $hebergements
        ));
    }

    /**
     * Lists all hebergement entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $hebergements = $em->getRepository('RefugeeBundle:Hebergement')->findAll();

        $route = '@Refugee/Hebergement/index.html.twig';

        if (!in_array("ROLE_SUPER_ADMIN", $this->getUser()->getRoles()))
        {
            $route = '@Refugee/front/Hebergement/index.html.twig';
        }

        $paginator = $this->get('knp_paginator');
        $hebergements =  $paginator->paginate($hebergements ,
            $request->query->getInt('page' , 1)  ,
            $request->query->getInt('limit ' , 6));

        return $this->render($route, array(
            'hebergements' => $hebergements
        ));
    }

    /**
     * Creates a new hebergement entity.
     *
     */
    public function newAction(Request $request)
    {
        $twig = '@Refugee/Hebergement/new.html.twig';
        $hebergement = new Hebergement();

        if (!in_array("ROLE_SUPER_ADMIN", $this->getUser()->getRoles()))
        {
            $twig = '@Refugee/front/Hebergement/new.html.twig';
        }

        $form = $this->createForm('RefugeeBundle\Form\HebergementType', $hebergement);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            $nbrRooms = $form->get('nbrRooms')->getData();
            $duration = $form->get('duration')->getData();

            if ($nbrRooms <= 0 || $duration <= 0)
            {
                return $this->render($twig, array(
                    'hebergement' => $hebergement,
                    'form' => $form->createView(),
                    'error' => 'valeurs invalides'
                ));
            }

            $em = $this->getDoctrine()->getManager();
            $hebergement->setCreationDate(new \DateTime());
            $hebergement->setState(0);
            $userId = $this->getUser()->getId();
            $user = $em->getRepository('AppBundle:User')->find($userId);
            $hebergement->setUser($user);


            //image upload
            $imageFile = $form->get('image')->getData();
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

            try {
                $imageFile->move(
                    $this->getParameter('hebergementImages_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            $hebergement->setImage($newFilename);

            $em->persist($hebergement);
            $em->flush();

            return $this->redirectToRoute('hebergement_index');
        }



        return $this->render($twig, array(
            'hebergement' => $hebergement,
            'form' => $form->createView(),
            'error' => null
        ));
    }




    /**
     * Finds and displays a hebergement entity.
     *
     */
    public function showAction(Hebergement $hebergement)
    {
        $deleteForm = $this->createDeleteForm($hebergement);

        return $this->render('@Refugee/Hebergement/show.html.twig', array(
            'hebergement' => $hebergement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing hebergement entity.
     *
     */
    public function editAction(Request $request, Hebergement $hebergement)
    {
        $deleteForm = $this->createDeleteForm($hebergement);
        $editForm = $this->createForm('RefugeeBundle\Form\HebergementType', $hebergement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('hebergement_edit', array('id' => $hebergement->getId()));
        }

        return $this->render('@Refugee/Hebergement/edit.html.twig', array(
            'hebergement' => $hebergement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a hebergement entity.
     *
     */
    public function deleteAction(Request $request, Hebergement $hebergement)
    {
        $form = $this->createDeleteForm($hebergement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($hebergement);
            $em->flush();
        }

        return $this->redirectToRoute('hebergement_index');
    }

    /**
     * Creates a form to delete a hebergement entity.
     *
     * @param Hebergement $hebergement The hebergement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Hebergement $hebergement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('hebergement_delete', array('id' => $hebergement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


}

// src/Controller/ProductController.php
namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/new", name="app_product_new")
     */
    public function new(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('brochure')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $product->setBrochureFilename($newFilename);
            }

            // ... persist the $product variable or any other work

            return $this->redirect($this->generateUrl('app_product_list'));
        }

        return $this->render('product/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
