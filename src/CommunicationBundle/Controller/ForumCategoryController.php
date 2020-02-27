<?php

namespace CommunicationBundle\Controller;

use CommunicationBundle\Entity\ForumCategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Forumcategory controller.
 *
 */
class ForumCategoryController extends Controller
{
    /**
     * Lists all forumCategory entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $forumCategories = $em->getRepository('CommunicationBundle:ForumCategory')->findAll();

        return $this->render('forumcategory/index.html.twig', array(
            'forumCategories' => $forumCategories,
        ));
    }
    public function homeAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();


        $forumCategories = $em->getRepository('CommunicationBundle:ForumCategory')->findAll();
        if ($request->isMethod("POST")) {
            $title = $request->get('title');
            $threads = $em->getRepository('CommunicationBundle:Threads')->findBy(array('title'=>$title));
            return $this->render('@Communication/Default/Recherche.html.twig', array(
                'threads' => $threads,
            ));
        }


        return $this->render('@Communication/Default/ForumCategory.html.twig', array(
            'forumCategories' => $forumCategories,
        ));
    }

    /**
     * Creates a new forumCategory entity.
     *
     */
    public function newAction(Request $request)
    {
        $forumCategory = new Forumcategory();
        $form = $this->createForm('CommunicationBundle\Form\ForumCategoryType', $forumCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($forumCategory);
            $em->flush();

            return $this->redirectToRoute('forumcategory_show', array('id' => $forumCategory->getId()));
        }

        return $this->render('forumcategory/new.html.twig', array(
            'forumCategory' => $forumCategory,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a forumCategory entity.
     *
     */
    public function showAction(ForumCategory $forumCategory)
    {
        $deleteForm = $this->createDeleteForm($forumCategory);

        return $this->render('forumcategory/show.html.twig', array(
            'forumCategory' => $forumCategory,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing forumCategory entity.
     *
     */
    public function editAction(Request $request, ForumCategory $forumCategory)
    {
        $deleteForm = $this->createDeleteForm($forumCategory);
        $editForm = $this->createForm('CommunicationBundle\Form\ForumCategoryType', $forumCategory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('forumcategory_edit', array('id' => $forumCategory->getId()));
        }

        return $this->render('forumcategory/edit.html.twig', array(
            'forumCategory' => $forumCategory,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a forumCategory entity.
     *
     */
    public function deleteAction(Request $request, ForumCategory $forumCategory)
    {
        $form = $this->createDeleteForm($forumCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($forumCategory);
            $em->flush();
        }

        return $this->redirectToRoute('forumcategory_index');
    }

    /**
     * Creates a form to delete a forumCategory entity.
     *
     * @param ForumCategory $forumCategory The forumCategory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ForumCategory $forumCategory)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('forumcategory_delete', array('id' => $forumCategory->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
