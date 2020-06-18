<?php

namespace DonsBundle\Controller;

use DonsBundle\DonsBundle;
use DonsBundle\Entity\Don;
use DonsBundle\Entity\PostLike;
use DonsBundle\Entity\Search;
use DonsBundle\Form\FilterType;
use DonsBundle\Form\SearchType;
use DonsBundle\Repository\PostLikeRepository;
use DonsBundle\Repository\SearchRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ObjectManager;


/**
 * Don controller.
 *
 */
class DonController extends Controller
{
    /**
     * Lists all don entities.
     *
     */
//    public function indexAction(Request $request)
//    {
//        $search = new Search();
//
//        $form = $this->createForm(SearchType::class, $search);
//        $form->handleRequest($request);
//
//        $em = $this->getDoctrine()->getManager();
//
//        $dql = "SELECT do FROM DonsBundle:Don do" ;
//
//        $query = $em->createQuery($dql);
//        /**
//         *@var $paginator Knp\Component\Pager\Paginator
//         */
//        if ($form->isSubmitted() && $form->isValid()){
//            $result = $this->getDoctrine()->getRepository(Don::class)
//                ->myFind($request->query->get('ups'));
//            $ups = $result[0]->getUps();
//            //return new Response($result[0]->getUps());
//            $dql = "SELECT do FROM DonsBundle:Don do WHERE do.ups =  :ups" ;
//            $query = $em->createQuery($dql)->setParameter('ups',$ups);
//            /**
//             *@var $paginator Knp\Component\Pager\Paginator
//             */
//            $paginator = $this->get('knp_paginator');
//            $result =  $paginator->paginate(
//            //$this->getDoctrine()->getRepository(Don::class)->myFind(3)[0],
//                $query ,
//                $request->query->getInt('page' , 1)  ,
//                $request->query->getInt('limit ' , 3)
//            );
//            return $this->render('don/index.html.twig', array(
//                'dons' => $result, 'form' => $form->createView()
//            ));
//        }
//
//
//
//
//        $paginator = $this->get('knp_paginator');
//        $result =  $paginator->paginate(
//            //$this->getDoctrine()->getRepository(Don::class)->myFind(3)[0],
//            $query ,
//            $request->query->getInt('page' , 1)  ,
//            $request->query->getInt('limit ' , 6)
//
//        );
//
//
//
//        return $this->render('don/index.html.twig', array(
//            'dons' => $result, 'form' => $form->createView()
//        ));
//    }


    public function searchAction(Request $request)
    {
        $addresse = $request->query->get('addresse') ? $request->query->get('addresse') : null;
        $ordreUps = $request->query->get('ordre_ups') ? $request->query->get('ordre_ups') : null;
        $domaine = $request->query->get('domaine') ? $request->query->get('domaine') : null;

        dump($ordreUps);

        $em = $this->getDoctrine()->getManager();

        $domaines = $em->getRepository('AssociationBundle:Category')->findAll();


        $dons = $em->getRepository('DonsBundle:Don')->search($addresse, $ordreUps, $domaine);
        $paginator = $this->get('knp_paginator');
        $dons_paginator =  $paginator->paginate($dons,
            $request->query->getInt('page' , 1)  ,
            $request->query->getInt('limit ' , 3));



        return $this->render('@Dons/don/index.html.twig', array(
            'dons' => $dons_paginator,
            'domaines' => $domaines
        ));
    }

    /**
     * Lists all don entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // $demandes = $em->getRepository('DonsBundle:Demande')->findAll();

        //paginate
        $dql = "SELECT de FROM DonsBundle:Don de" ;
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $result =  $paginator->paginate($query ,
            $request->query->getInt('page' , 1)  ,
            $request->query->getInt('limit ' , 6));


        $domaines = $em->getRepository('AssociationBundle:Category')->findAll();


        return $this->render('@Dons/don/index.html.twig', array(
            'dons' => $result,
            'domaines' => $domaines
        ));
    }

    /**
     * Creates a new don entity.
     *
     */
    public function newAction(Request $request)
    {

        $don = new Don();
        $form = $this->createForm('DonsBundle\Form\DonType', $don);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $don->setLatitude($request->request->get('lat_don'));
            $don->setLongitude($request->request->get('lng_don'));
            $em = $this->getDoctrine()->getManager();

            $don->setCreationDate(new\DateTime());
            $userId = $this->getUser()->getId();
            $user = $em->getRepository('AppBundle:User')->find($userId);
            $don->setUser($user);


            $imageFile = $form->get('image')->getData();
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

            try {
                $imageFile->move(
                    $this->getParameter('donImages_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            $don->setImage($newFilename);




            $em->persist($don);
            $em->flush();

            return $this->redirectToRoute('don_show', array('id' => $don->getId()));
        }

        return $this->render('@Dons/don/new.html.twig', array(
            'don' => $don,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a don entity.
     *
     */
    public function showAction(Don $don)
    {
        $deleteForm = $this->createDeleteForm($don);

        return $this->render('@Dons/don/show.html.twig', array(
            'don' => $don,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing don entity.
     *
     */
    public function editAction(Request $request, Don $don)
    {
        $deleteForm = $this->createDeleteForm($don);
        $editForm = $this->createForm('DonsBundle\Form\DonType', $don);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('don_edit', array('id' => $don->getId()));
        }

        return $this->render('don/edit.html.twig', array(
            'don' => $don,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a don entity.
     *
     */
    public function deleteAction(Request $request, Don $don)
    {
        $form = $this->createDeleteForm($don);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($don);
            $em->flush();
        }

        return $this->redirectToRoute('don_index');
    }

    /**
     * Creates a form to delete a don entity.
     *
     * @param Don $don The don entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Don $don)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('don_delete', array('id' => $don->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function homeAction()
    {


        return $this->render('don/home.html.twig'
        );
    }

    public function likeAction(Don $don)
    {


        $user = $this->getUser();

        if (!$user) {
            return $this->json(['code' => 403, 'error' => 'Vous devez être connecté !'], 403);
        }
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array('username'=>$this->getUser()->getUsername()));
        if ($don->isLikedByUser($user)) {
            $like = $this->getDoctrine()->getRepository('DonsBundle:PostLike')->findOneBy(['don' => $don, 'user' => $user]);

            $this->getDoctrine()->getManager()->remove($like);
            $this->getDoctrine()->getManager()->flush();

            return $this->json(['code' => 200, 'likes' => $this->getDoctrine()->getRepository('DonsBundle:PostLike')->countByDon($don)], 200);

        }

        $like = new PostLike();
        $like->setDon($don)
            ->setUser($user);

        $this->getDoctrine()->getManager()->persist($like);
        $this->getDoctrine()->getManager()->flush();

        return $this->json(['code' => 200, 'likes' => $this->getDoctrine()->getRepository('DonsBundle:PostLike')->countByDon($don)], 200);
    }


}
