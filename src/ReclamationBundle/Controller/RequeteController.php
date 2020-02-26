<?php

namespace ReclamationBundle\Controller;

use ReclamationBundle\Entity\Requete;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Requete controller.
 *
 */
class RequeteController extends Controller
{
    /**
     * Lists all requete entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $requetes = $em->getRepository('ReclamationBundle:Requete')->findAll();

        return $this->render('@Reclamation/requete/index.html.twig', array(
            'requetes' => $requetes,
        ));
    }

    /**
     * Creates a new requete entity.
     *
     */
    public function newAction(Request $request)
    {
        $requete = new Requete();
        $form = $this->createForm('ReclamationBundle\Form\RequeteType', $requete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $requete->setDernierMAJ(new \DateTime());
            $requete->setStatut(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($requete);
            $em->flush();

            return $this->redirectToRoute('requete_show', array('id' => $requete->getId()));
        }

        return $this->render('@Reclamation/requete/new.html.twig', array(
            'requete' => $requete,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new requete entity.
     *
     */
    public function addAction(Request $request){
        $req= new Requete();
        $current = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array('username'=>$this->getUser()->getUsername()));
        if($request->isMethod('POST')){
            if($request->get('type')){
                $req->setType($request->get('type'));
            }
            if($request->get('sujet')){
                $req->setSujet($request->get('sujet'));
            }if($request->get('description')){
                $req->setDescription($request->get('description'));
            }
            $req->setUser($current);
            $req->setDernierMAJ(new \DateTime());
            $req->setStatut(0);
            $em=$this->getDoctrine()->getManager();
            $em->persist($req);
            $em->flush();
            return $this->redirectToRoute('reaclamation_homepage');
        }
        return $this->render('@Reclamation/requete/requetefront.html.twig');
    }

    /**
     * Finds and displays a requete entity.
     *
     */
    public function showAction(Requete $requete)
    {
        $deleteForm = $this->createDeleteForm($requete);

        return $this->render('@Reclamation/requete/show.html.twig', array(
            'requete' => $requete,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing requete entity.
     *
     */
    public function editAction(Request $request, Requete $requete)
    {
        $deleteForm = $this->createDeleteForm($requete);
        $editForm = $this->createForm('ReclamationBundle\Form\RequeteType', $requete);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('requete_edit', array('id' => $requete->getId()));
        }

        return $this->render('@Reclamation/requete/edit.html.twig', array(
            'requete' => $requete,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a requete entity.
     *
     */
    public function deleteAction(Request $request, Requete $requete)
    {
        $form = $this->createDeleteForm($requete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($requete);
            $em->flush();
        }

        return $this->redirectToRoute('requete_index');
    }

    /**
     * Creates a form to delete a requete entity.
     *
     * @param Requete $requete The requete entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Requete $requete)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('requete_delete', array('id' => $requete->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    public function affichAction()
    {
        $em = $this->getDoctrine()->getManager();

        $requet = $em->getRepository('ReclamationBundle:Requete')->findAll();

        return $this->render('@Reclamation/requetefront/rquetefronts.html.twig', array(
            'requet' => $requet,
        ));
    }

    public function ticketaction(){
            return $this->render('@Reclamation/requetefront/requetefront.html.twig');
    }

    public function filtrestatutAction(Request $request,$statut){
        $em = $this->getDoctrine()->getManager();
        $findbystatut=$em->getRepository('ReclamationBundle:Requete')->findBy(array("statut" => $statut));
            return $this->render('@Reclamation/requetefront/rquetefronts.html.twig', array(
                'requet' => $findbystatut,));

        }
}
