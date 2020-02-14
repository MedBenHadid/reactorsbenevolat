<?php

namespace AssociationBundle\Controller;

use AppBundle\Entity\User;
use AssociationBundle\Entity\Association;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Association controller.
 *
 * @Route("/association")
 */
class AssociationController extends Controller
{
    /**
     * @Route("/", name="association_index",methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $associations = $em->getRepository('AssociationBundle:Association')->findAll();

        return $this->render('@Association/association/index.html.twig', array(
            'associations' => $associations,
        ));
    }

    /**
     * @Route("/register", name="association_register",methods={"GET","POST"})
     */
    public function registerAction(Request $request)
    {
        $association = new Association();

        $form = $this->createForm('AssociationBundle\Form\AssociationType', $association);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $file
             */
            // Setting admin user as the one that issues the request
            $user = $this->getUser();
            $user->addRole(User::ASSOCIATION_ADMIN);
            $association->setAdmin($user);

            // Setting association as disabled until admin confirmation
            $association->setIsActivated(false);

            $file=$form->get('image')->getData();
            $filename = md5(uniqid('', true)).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_dir'),$filename);

            $association->setImage($filename);

            $em = $this->getDoctrine()->getManager();
            $em->persist($association);
            $em->flush();

            return $this->redirectToRoute('association_show', array('id' => $association->getId()));
        }

        return $this->render('@Association/association/new.html.twig', array(
            'association' => $association,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/new", name="association_new",methods={"GET","POST"})
     */
    public function newAction(Request $request)
    {
        $association = new Association();
        $form = $this->createForm('AssociationBundle\Form\AssociationType', $association);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($association);
            $em->flush();

            return $this->redirectToRoute('association_show', array('id' => $association->getId()));
        }

        return $this->render('@Association/association/new.html.twig', array(
            'association' => $association,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}", name="association_show",methods={"GET"})
     */
    public function showAction(Association $association)
    {
        $deleteForm = $this->createDeleteForm($association);

        return $this->render('@Association/association/show.html.twig', array(
            'association' => $association,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", name="association_edit",methods={"GET","POST"})
     */
    public function editAction(Request $request, Association $association)
    {
        $deleteForm = $this->createDeleteForm($association);
        $editForm = $this->createForm('AssociationBundle\Form\AssociationType', $association);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('association_edit', array('id' => $association->getId()));
        }

        return $this->render('association/edit.html.twig', array(
            'association' => $association,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/{id}", name="association_delete",methods={"DELETE"})
     */
    public function deleteAction(Request $request, Association $association)
    {
        $form = $this->createDeleteForm($association);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($association);
            $em->flush();
        }

        return $this->redirectToRoute('association_index');
    }

    /**
     * Creates a form to delete a association entity.
     *
     * @param Association $association The association entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Association $association)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('association_delete', array('id' => $association->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
