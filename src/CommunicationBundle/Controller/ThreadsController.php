<?php

namespace CommunicationBundle\Controller;

use CommunicationBundle\Entity\Threads;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Thread controller.
 *
 */
class ThreadsController extends Controller
{
    /**
     * Lists all thread entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $threads = $em->getRepository('CommunicationBundle:Threads')->findAll();

        return $this->render('threads/index.html.twig', array(
            'threads' => $threads,
        ));
    }
    public function homeAction(Request $request)
    {
        $categoryName = $request->query->get('categorie');

        $em = $this->getDoctrine()->getManager();


        $threads = $em->getRepository('CommunicationBundle:Threads')->findByCategoryName($categoryName);


        return $this->render('@Communication/Default/Threads.html.twig', array('threads' => $threads));
    }

    /**
     * Creates a new thread entity.
     *
     */
    public function newAction(Request $request)
    {
        $thread = new Threads();
        $form = $this->createForm('CommunicationBundle\Form\ThreadsType', $thread);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($thread);
            $em->flush();

            return $this->redirectToRoute('threads_show', array('id' => $thread->getId()));
        }

        return $this->render('threads/new.html.twig', array(
            'thread' => $thread,
            'form' => $form->createView(),
        ));
    }
    public function addAction(Request $request)
    {
        $thread = new Threads();
        $form = $this->createForm('CommunicationBundle\Form\ThreadsType', $thread);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $thread->setLastmodified(new \DateTime());
            $userId = $this->getUser()->getId();
            $user = $em->getRepository('AppBundle:User')->find($userId);
            $thread->setUser($user);
            $em->persist($thread);
            $em->flush();

            return $this->redirectToRoute('threads_show', array('id' => $thread->getId()));
        }

        return $this->render('threads/thread.html.twig', array(
            'thread' => $thread,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a thread entity.
     *
     */
    public function showAction(Threads $thread)
    {
        $deleteForm = $this->createDeleteForm($thread);

        return $this->render('threads/show.html.twig', array(
            'thread' => $thread,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    public function showFrontAction(Request $request)
    {


        $thread_id = $request->query->get('id');

        $em = $this->getDoctrine()->getManager();

        $comments = $em->getRepository('CommunicationBundle:Comments')->findByThread($thread_id);

        $thread = $em->getRepository('CommunicationBundle:Threads')->find($thread_id);

        $deleteForm = $this->createDeleteForm($thread);

        return $this->render('@Communication/Default/ThreadComments.html.twig', array(
            'thread' => $thread,
            'delete_form' => $deleteForm->createView(),
            'comment' => $comments
        ));

    }

    /**
     * Displays a form to edit an existing thread entity.
     *
     */
    public function editAction(Request $request, Threads $thread)
    {
        $deleteForm = $this->createDeleteForm($thread);
        $editForm = $this->createForm('CommunicationBundle\Form\ThreadsType', $thread);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('threads_edit', array('id' => $thread->getId()));
        }

        return $this->render('threads/edit.html.twig', array(
            'thread' => $thread,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a thread entity.
     *
     */
    public function deleteAction(Request $request, Threads $thread)
    {
        $form = $this->createDeleteForm($thread);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($thread);
            $em->flush();
        }

        return $this->redirectToRoute('threads_index');
    }

    /**
     * Creates a form to delete a thread entity.
     *
     * @param Threads $thread The thread entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Threads $thread)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('threads_delete', array('id' => $thread->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
