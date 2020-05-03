<?php

namespace AssociationBundle\Controller;

use AssociationBundle\Entity\Association;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
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
     * @Route(path="/domaines", name="api_domaines_paginated", methods={"GET"})
     * @return JsonResponse
     */
    public function domainesAction(): JsonResponse
    {
        $serializer = new Serializer(array(new ObjectNormalizer()), array(new JsonEncoder()));
        return new JsonResponse($serializer->normalize($this->getDoctrine()->getRepository('AssociationBundle:Category')->findAll()));
    }

    /**
     * @Route(path="/associations/memberships/{id}/{oneForAssociation}/{status}", defaults={"status":"ACCEPTED"}, name="api_association_memberships", methods={"GET"}, requirements={"page"="\d+"})
     * @param int $id
     * @param $oneForAssociation
     * @param $status
     * @return JsonResponse
     */
    public function membershipsAction($id,$oneForAssociation,$status): JsonResponse
    {
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(static function ($object) {return $object->getId();});
        $serializer = new Serializer(array($normalizer), array(new JsonEncoder()));
        if ($oneForAssociation==1)
            $query = 'SELECT m FROM AssociationBundle:Adherance m WHERE m.association = :id AND m.status = :status ';
        else
            $query = 'SELECT m FROM AssociationBundle:Adherance m WHERE m.user = :id AND m.status = :status ';
        $query = $this->getDoctrine()->getManager()->createQuery($query)->setParameter('id',$id)->setParameter('status',$status);

        return new JsonResponse($serializer->normalize($query->execute()));
    }
    // mazelt matemchich

    /**
     * @Route(path="/association", name="api_association_add",methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addAction(Request $request): JsonResponse
    {
        $content =$request->getContent();
        if (!empty($content))
        {
            $a = new Association();
            $params = json_decode($content,false);
            $a->setDomaine($this->getDoctrine()->getRepository('AssociationBundle:Category')->find($params->domaine));
            $a->setManager($this->getDoctrine()->getRepository('AppBundle:User')->find($params->manager));
            $a->setNom($params->nom);
            $a->setDescription($params->description);
            $a->setApprouved($params->approuved);
            $a->setTelephone($params->telephone);
            $a->setCodePostal($params->codePostal);
            $a->setVille($params->ville);
            $a->setLatitude($params->lat);
            $a->setLongitude($params->lon);
            $a->setPieceJustificatif($params->pieceJustificatif);
            $a->setPhoto($params->photoAgence);
            $a->setHoraireTravail($params->horaireTravail);

            $em = $this->getDoctrine()->getManager();
            $em->persist($a);
            $em->flush();
            return new JsonResponse($a->getId(), Response::HTTP_CREATED);
        }
        return new JsonResponse('Page not found.', Response::HTTP_BAD_REQUEST);


    }



}
