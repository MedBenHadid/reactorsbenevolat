<?php

namespace DonsBundle\Controller;

use DonsBundle\Entity\ImageDon;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Imagedon controller.
 *
 */
class ImageDonController extends Controller
{
    /**
     * Lists all imageDon entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $imageDons = $em->getRepository('DonsBundle:ImageDon')->findAll();

        return $this->render('imagedon/index.html.twig', array(
            'imageDons' => $imageDons,
        ));
    }

    /**
     * Creates a new imageDon entity.
     *
     */
    public function newAction(Request $request)
    {
        $imageDon = new Imagedon();
        $form = $this->createForm('DonsBundle\Form\ImageDonType', $imageDon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile=$form->get('image')->getData();

            if($imageFile)
            {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('dons_image_directory'),
                        $newFilename
                    );
                }      catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
                $imageDon->setImage($newFilename);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($imageDon);
            $em->flush();

            return $this->redirectToRoute('imagedon_show', array('id' => $imageDon->getId()));
        }

        return $this->render('imagedon/new.html.twig', array(
            'imageDon' => $imageDon,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a imageDon entity.
     *
     */
    public function showAction(ImageDon $imageDon)
    {
        $deleteForm = $this->createDeleteForm($imageDon);

        return $this->render('imagedon/show.html.twig', array(
            'imageDon' => $imageDon,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing imageDon entity.
     *
     */
    public function editAction(Request $request, ImageDon $imageDon)
    {
        $deleteForm = $this->createDeleteForm($imageDon);
        $editForm = $this->createForm('DonsBundle\Form\ImageDonType', $imageDon);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('imagedon_edit', array('id' => $imageDon->getId()));
        }

        return $this->render('imagedon/edit.html.twig', array(
            'imageDon' => $imageDon,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a imageDon entity.
     *
     */
    public function deleteAction(Request $request, ImageDon $imageDon)
    {
        $form = $this->createDeleteForm($imageDon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($imageDon);
            $em->flush();
        }

        return $this->redirectToRoute('imagedon_index');
    }

    /**
     * Creates a form to delete a imageDon entity.
     *
     * @param ImageDon $imageDon The imageDon entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ImageDon $imageDon)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('imagedon_delete', array('id' => $imageDon->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
