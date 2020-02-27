<?php

namespace AssociationBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\User;
use AssociationBundle\Entity\Association;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * SuperAdmin controller.
 *
 * @Route("/dashboard/admin/association")
 *
 */
class SuperAdminController extends Controller
{
    /**
     * @Route(path="/approve/{id}", name="admin_association_approve",methods={"GET"})
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function approveAction($id){
        $association = $this->getDoctrine()->getRepository('AssociationBundle:Association')->find($id);
        /** @var  $user User */
        $user = $association->getManager();
        $user->setApprouved(true);
        $user->setEnabled(true);
        $association->setApprouved(true);


        $em = $this->getDoctrine()->getManager();

        $em->persist($association);
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('admin_association_index');
    }

    /**
     * @Route(path="/ban/{id}", name="admin_association_ban",methods={"GET"})
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function banAction($id)
    {
        $association = $this->getDoctrine()->getRepository('AssociationBundle:Association')->find($id);
        /** @var $user User */
        $user = $association->getManager();
        $user->setBanned(true);
        $user->setApprouved(false);
        $user->setEnabled(false);
        $association->setApprouved(false);
        $em = $this->getDoctrine()->getManager();

        $adherances = $this->getDoctrine()->getRepository('AssociationBundle:Adherance')->findBy(array('association'=>$association));
        foreach ($adherances as $adherance){
            $em->remove($adherance);
        }
        $em->flush();

        $em->remove($association);
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('admin_association_index');
    }

    /**
     * @Route(path="/", name="admin_association_index",methods={"GET"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $dql = "SELECT a FROM AssociationBundle:Association a" ;
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $result =  $paginator->paginate($query ,
            $request->query->getInt('page' , 1)  ,
            $request->query->getInt('limit ' , 2));

        $associations = $em->getRepository('AssociationBundle:Association')->findAll();
        return $this->render('@Association/dashboard/association/index.html.twig', array(
            'associations' => $result,
        ));
    }

    /**
     * @Route(path="/category", name="admin_category_index",methods={"GET"})
     */
    public function categoryIndexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('AssociationBundle:Category')->findAll();

        return $this->render('@Association/dashboard/category/index.html.twig', array(
            'categories' => $categories,
        ));
    }

    /**
     * @Route(path="/new", name="admin_association_new",methods={"GET","POST"})
     * @IsGranted("ROLE_SUPER_ADMIN")
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

            return $this->redirectToRoute('admin_association_show', array('id' => $association->getId()));
        }

        return $this->render('@Association/dashboard/association/new.html.twig', array(
            'association' => $association,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route(path="/{id}", name="admin_association_show",methods={"GET"})
     */
    public function showAction(Association $association)
    {

        return $this->render('@Association/dashboard/association/show.html.twig', array(
            'association' => $association
        ));
    }


    /**
     * @IsGranted("ROLE_SUPER_ADMIN")
     * @Route(path="/{id}/edit", name="admin_association_edit",methods={"GET","POST"})
     */
    public function editAction(Request $request, Association $association)
    {
        $editForm = $this->createForm('AssociationBundle\Form\AssociationType', $association);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_association_edit', array('id' => $association->getId()));
        }

        return $this->render('@Association/dashboard/association/edit.html.twig', array(
            'association' => $association,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * @Route(path="/{id}", name="admin_association_delete")
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function deleteAction($id)
    {
        $association=$this->getDoctrine()->getRepository('AssociationBundle:Association')->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($association);
        $em->flush();
        return $this->redirectToRoute('admin_association_index');
    }




}
