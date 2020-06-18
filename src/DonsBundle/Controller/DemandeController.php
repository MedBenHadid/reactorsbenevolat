<?php

namespace DonsBundle\Controller;

use DonsBundle\Entity\Demande;
use DonsBundle\Entity\PostLike;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Demande controller.
 *
 */
class DemandeController extends Controller
{



    public function searchAction(Request $request)
    {
        $addresse = $request->query->get('adresse') ? $request->query->get('addresse') : null;
        $ordreUps = $request->query->get('odre_ups') ? $request->query->get('ordre_ups') : null;
        $domaine = $request->query->get('domaine') ? $request->query->get('domaine') : null;

        $em = $this->getDoctrine()->getManager();

        $domaines = $em->getRepository('AssociationBundle:Category')->findAll();


        $demandes = $em->getRepository('DonsBundle:Demande')->search($addresse, $ordreUps, $domaine);
        $paginator = $this->get('knp_paginator');
        $demandes_paginator =  $paginator->paginate($demandes,
            $request->query->getInt('page' , 1)  ,
            $request->query->getInt('limit ' , 6));



        return $this->render('@Dons/demande/index.html.twig', array(
            'demandes' => $demandes_paginator,
            'domaines' => $domaines
        ));
    }



    /**
     * Lists all demande entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

       // $demandes = $em->getRepository('DonsBundle:Demande')->findAll();
        $dql = "SELECT de FROM DonsBundle:Demande de" ;
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $result =  $paginator->paginate($query ,
            $request->query->getInt('page' , 1)  ,
            $request->query->getInt('limit ' , 6));
<<<<<<< HEAD



        $domaines = $em->getRepository('AssociationBundle:Category')->findAll();


=======



        $domaines = $em->getRepository('AssociationBundle:Category')->findAll();


>>>>>>> 828daa075d4193b154f76a7094238bc737adb040
        return $this->render('@Dons/demande/index.html.twig', array(
            'demandes' => $result,
            'domaines' => $domaines
        ));
    }

    /**
     * Creates a new demande entity.
     *
     */
    public function newAction(Request $request)
    {

        $demande = new Demande();
        $form = $this->createForm('DonsBundle\Form\DemandeType', $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        var_dump($request->request->get('lat_don'));
            $demande->setLatitude($request->request->get('lat_demande'));
            $demande->setLongitude($request->request->get('lng_demande'));
            $em = $this->getDoctrine()->getManager();

            $demande->setCreationDate(new\DateTime());
            $userId = $this->getUser()->getId();
            $user = $em->getRepository('AppBundle:User')->find($userId);
            $demande->setUser($user);



            $imageFile = $form->get('image')->getData();
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

            try {
                $imageFile->move(
                    $this->getParameter('demandeImages_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            $demande->setImage($newFilename);

            $em->persist($demande);
            $em->flush();


            return $this->redirectToRoute('demande_show', array('id' => $demande->getId()));
        }

<<<<<<< HEAD
        return $this->render('@dons/demande/new.html.twig', array(
=======
        return $this->render('@Dons/demande/new.html.twig', array(
>>>>>>> 828daa075d4193b154f76a7094238bc737adb040
            'demande' => $demande,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a demande entity.
     *
     */
    public function showAction(Demande $demande)
    {
        $deleteForm = $this->createDeleteForm($demande);

        return $this->render('@Dons/demande/show.html.twig', array(
            'demande' => $demande,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing demande entity.
     *
     */
    public function editAction(Request $request, Demande $demande)
    {
        $deleteForm = $this->createDeleteForm($demande);
        $editForm = $this->createForm('DonsBundle\Form\DemandeType', $demande);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('demande_edit', array('id' => $demande->getId()));
        }

        return $this->render('demande/edit.html.twig', array(
            'demande' => $demande,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a demande entity.
     *
     */
    public function deleteAction(Request $request, Demande $demande)
    {
        $form = $this->createDeleteForm($demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($demande);
            $em->flush();
        }

        return $this->redirectToRoute('demande_index');
    }

    /**
     * Creates a form to delete a demande entity.
     *
     * @param Demande $demande The demande entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Demande $demande)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('demande_delete', array('id' => $demande->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }



    public function likeAction(Demande $demande)
    {


        $user = $this->getUser();

        if (!$user) {
            return $this->json(['code' => 403, 'error' => 'Vous devez être connecté !'], 403);
        }
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array('username'=>$this->getUser()->getUsername()));
        if ($demande->isLikedByUser($user)) {
            $like = $this->getDoctrine()->getRepository('DonsBundle:PostLike')->findOneBy(['demande' => $demande, 'user' => $user]);

            $this->getDoctrine()->getManager()->remove($like);
            $this->getDoctrine()->getManager()->flush();

            return $this->json(['code' => 200, 'likes' => $this->getDoctrine()->getRepository('DonsBundle:PostLike')->countByDon($demande)], 200);

        }

        $like = new PostLike();
        $like->setDon($demande)
            ->setUser($user);

        $this->getDoctrine()->getManager()->persist($like);
        $this->getDoctrine()->getManager()->flush();

        return $this->json(['code' => 200, 'likes' => $this->getDoctrine()->getRepository('DonsBundle:PostLike')->countByDon($demande)], 200);
    }


}
