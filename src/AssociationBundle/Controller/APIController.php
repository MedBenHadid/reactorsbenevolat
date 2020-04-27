<?php

namespace AssociationBundle\Controller;

use AssociationBundle\Entity\Association;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * API controller.
 *
 * @Route("/api")
 */
class APIController extends Controller
{
    /**
     * @Route(path="/associations/image/{name}", name="api_fetch_image",methods={"GET"})
     * @param $name
     * @return BinaryFileResponse
     */
    public function fetchImage($name): BinaryFileResponse
    {
        return new BinaryFileResponse($this->getParameter('association_image_directory'). '/' .$name);
    }
    /**
     * @Route(path="/associations/file/{name}", name="api_fetch_file",methods={"GET"})
     * @param $name
     * @return BinaryFileResponse
     */
    public function fetchDocument($name): BinaryFileResponse
    {
        return new BinaryFileResponse($this->getParameter('pieces_directory'). '/' .$name);
    }

    /**
     * @Route(path="/associations/{page}/{nom}/{ville}", defaults={"nom":"","ville":"","page":1}, name="api_association_index", methods={"GET"}, requirements={"page"="\d+"})
     * @param String $nom
     * @param String $ville
     * @param int $page
     * @return JsonResponse
     */
    public function associationsAction(String $nom, String $ville,$page): JsonResponse
    {
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(static function ($object) {return $object->getId();});
        $serializer = new Serializer(array($normalizer), array(new JsonEncoder()));
        return new JsonResponse($serializer->normalize($this->get('knp_paginator')->paginate($this->getDoctrine()->getManager()->createQuery('SELECT a FROM AssociationBundle:Association a WHERE a.nom LIKE :nom AND a.ville LIKE :ville AND a.approuved=true')->setParameter('nom',$nom.'%')->setParameter('ville',$ville.'%'), $page, 5)));
    }

    /**
     * @Route(path="/associations/memberships/{id}/{page}", defaults={"page":1}, name="api_association_memberships", methods={"GET"}, requirements={"page"="\d+"})
     * @param int $id
     * @param int $page
     * @return JsonResponse
     */
    public function membershipsAction($id,$page): JsonResponse
    {
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(static function ($object) {return $object->getId();});
        $serializer = new Serializer(array($normalizer), array(new JsonEncoder()));
        return new JsonResponse($serializer->normalize($this->get('knp_paginator')->paginate($this->getDoctrine()->getManager()->createQuery('SELECT m FROM AssociationBundle:Adherance m WHERE m.association = :id ')->setParameter('id',$id), $page, 5)));
    }
    // mazelt matemchich
    /**
     * @Route(path="/association", name="api_association_add",methods={"PUT"})
     * @param Association $association
     * @return JsonResponse
     */
    public function addAction(Association $association): JsonResponse
    {
        // * @IsGranted("ROLE_SUPER_ADMIN")
        $em = $this->getDoctrine()->getManager();
        $em->persist($association);
        $em->flush();
        return new JsonResponse(z);
    }



}
