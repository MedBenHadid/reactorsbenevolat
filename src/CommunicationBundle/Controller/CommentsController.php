<?php

namespace CommunicationBundle\Controller;

use CommunicationBundle\Entity\Comments;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Comment controller.
 *
 */
class CommentsController extends Controller
{
    /**
     * Lists all comment entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $comments = $em->getRepository('CommunicationBundle:Comments')->findAll();

        return $this->render('comments/index.html.twig', array(
            'comments' => $comments,
        ));
    }
    public function commentFrontAction()
    {
        $em = $this->getDoctrine()->getManager();

        $comments = $em->getRepository('CommunicationBundle:Comments')->findAll();

        return $this->render('@Communication/Default/ThreadComments.html.twig', array(
            'comment' => $comments,
        ));
    }

    public function newFrontAction(Request $request)
    {
       $content = $request->request->get('comment') ? $request->request->get('comment') : null;
        $threadId = $request->request->get('thread_id') ? $request->request->get('thread_id') : null;

        $em = $this->getDoctrine()->getManager();

        $comment = new Comments();

        $comment->setContent($content);
        $comment->setDate(new \DateTime());


        $thread = $em->getRepository('CommunicationBundle:Threads')->find($threadId);



        $comment->setThread($thread);
        $userId = $this->getUser()->getId();
        $user = $em->getRepository('AppBundle:User')->find($userId);
        $comment->setUser($user);

        $em->persist($comment);
        $em->flush();



        $threads = $em->getRepository('CommunicationBundle:Threads')->findAll();
        $nthreads = count($threads);

        return $this->render('@Communication/Default/Threads.html.twig', array('threads' => $threads,'nthreads' => $nthreads));
    }


    /**
     * Creates a new comment entity.
     *
     */
    public function newAction(Request $request)
    {

        $comment = new Comments();
        $form = $this->createForm('CommunicationBundle\Form\CommentsType', $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('comments_show', array('id' => $comment->getId()));
        }

        return $this->render('comments/new.html.twig', array(
            'comment' => $comment,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a comment entity.
     *
     */
    public function showAction(Comments $comment)
    {
        $deleteForm = $this->createDeleteForm($comment);

        return $this->render('comments/show.html.twig', array(
            'comment' => $comment,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing comment entity.
     *
     */
    public function editAction(Request $request, Comments $comment)
    {
        $deleteForm = $this->createDeleteForm($comment);
        $editForm = $this->createForm('CommunicationBundle\Form\CommentsType', $comment);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comments_edit', array('id' => $comment->getId()));
        }

        return $this->render('comments/edit.html.twig', array(
            'comment' => $comment,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a comment entity.
     *
     */
    public function deleteAction(Request $request, Comments $comment)
    {
        $form = $this->createDeleteForm($comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comment);
            $em->flush();
        }

        return $this->redirectToRoute('comments_index');
    }

    /**
     * Creates a form to delete a comment entity.
     *
     * @param Comments $comment The comment entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Comments $comment)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comments_delete', array('id' => $comment->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
