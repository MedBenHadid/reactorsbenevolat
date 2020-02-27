<?php

namespace RefugeeBundle\Controller;

use RefugeeBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Comment controller.
 *
 */
class CommentController extends Controller
{
    /**
     * Lists all comment entities.
     *
     */
    public function indexAction(Request $request)
    {
        $hebergementId = $request->query->get('hebergementId') ? $request->query->get('hebergementId') : null;

        dump($hebergementId);
        $em = $this->getDoctrine()->getManager();

        $criteria = ['hebergement' => $hebergementId];
        $comments = $em->getRepository('RefugeeBundle:Comment')->findBy($criteria);
        $nbrComments = $em->getRepository('RefugeeBundle:Comment')->nbrCommentsByHebergement($hebergementId);
        $hebergement = $em->getRepository('RefugeeBundle:Hebergement')->find($hebergementId);

        dump($comments);

        return $this->render('@Refugee/front/comment/index.html.twig', array(
            'comments' => $comments,
            'hebergement' => $hebergement,
            'nbrComments' => $nbrComments
        ));
    }

    /**
     * Creates a new comment entity.
     *
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $message = $request->query->get('message') ? $request->query->get('message') : null;
        $hebergementId = $request->query->get('hebergementId') ? $request->query->get('hebergementId') : null;


        $hebergement = $em->getRepository('RefugeeBundle:Hebergement')->find($hebergementId);
        $comment = new Comment();
        $comment->setHebergement($hebergement);
        $comment->setContent($message);
        $comment->setCreationDate(new \DateTime());
        $userId = $this->getUser()->getId();
        $user = $em->getRepository('AppBundle:User')->find($userId);
        $comment->setUser($user);



        $em->persist($comment);
        $em->flush();

        $criteria = ['hebergement' => $hebergementId];
        $comments = $em->getRepository('RefugeeBundle:Comment')->findOrdreByDate($hebergementId);
        $nbrComments = $em->getRepository('RefugeeBundle:Comment')->nbrCommentsByHebergement($hebergementId);


        return $this->render('@Refugee/front/comment/index.html.twig', array(
            'comments' => $comments,
            'hebergement' => $hebergement,
            'nbrComments' => $nbrComments
        ));
    }

    /**
     * Finds and displays a comment entity.
     *
     */
    public function showAction(Comment $comment)
    {
        $deleteForm = $this->createDeleteForm($comment);

        return $this->render('@Refugee/front/comment/show.html.twig', array(
            'comment' => $comment,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing comment entity.
     *
     */
    public function editAction(Request $request, Comment $comment)
    {
        $deleteForm = $this->createDeleteForm($comment);
        $editForm = $this->createForm('RefugeeBundle\Form\CommentType', $comment);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comment_edit', array('id' => $comment->getId()));
        }

        return $this->render('@Refugee/front/comment/edit.html.twig', array(
            'comment' => $comment,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a comment entity.
     *
     */
    public function deleteAction(Request $request, Comment $comment)
    {
        $form = $this->createDeleteForm($comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comment);
            $em->flush();
        }

        return $this->redirectToRoute('comment_index');
    }

    /**
     * Creates a form to delete a comment entity.
     *
     * @param Comment $comment The comment entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Comment $comment)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comment_delete', array('id' => $comment->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
