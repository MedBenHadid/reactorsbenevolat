<?php

namespace AssociationBundle\Controller;

use AssociationBundle\Entity\Adherance;
use AssociationBundle\Entity\Association;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
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
    // TODO : Upload fil & image
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
     * @Route(path="/associations/findoneby/manager/{managerId}", name="api_association_lookup_by_manager", methods={"GET"})
     * @param $managerId
     * @return JsonResponse
     */
    public function lookupAssociationByManagerAction($managerId): JsonResponse
    {
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(static function ($object) {return $object->getId();});
        $serializer = new Serializer(array($normalizer), array(new JsonEncoder()));
        return new JsonResponse($serializer->normalize($this->getDoctrine()->getRepository('AssociationBundle:Association')->findOneBy(['manager' => $managerId])));
    }
    /**
     * @Route(path="/association/one/{assId}", name="api_association_lookup_by_id", methods={"GET"})
     * @param $assId
     * @return JsonResponse
     */
    public function lookupAssociationByIdAction($assId): JsonResponse
    {
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(static function ($object) {return $object->getId();});
        $serializer = new Serializer(array($normalizer), array(new JsonEncoder()));
        return new JsonResponse($serializer->normalize($this->getDoctrine()->getRepository('AssociationBundle:Association')->find($assId)));
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
    public function listMembershipsAction($id,$oneForAssociation,$status): JsonResponse
    {
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(static function ($object) {return $object->getId();});
        $serializer = new Serializer(array($normalizer), array(new JsonEncoder()));
        if( $status=="ALL")
            return new JsonResponse($serializer->normalize($this->getDoctrine()->getRepository('AssociationBundle:Adherance')->findAll()));
        else if ($oneForAssociation==1)
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
    public function addAssociationAction(Request $request): JsonResponse
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
            $a->setRue($params->rue);
            $a->setPieceJustificatif($params->pieceJustificatif);
            $a->setPhoto($params->photoAgence);
            $a->setHoraireTravail($params->horaireTravail);

            $em = $this->getDoctrine()->getManager();
            $em->persist($a);
            $em->flush();
            return new JsonResponse(array("id"=>$a->getId()), Response::HTTP_CREATED);
        }
        return new JsonResponse('Page not found.', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route(path="/association/update", name="api_association_update",methods={"PATCH"})
     * @param Request $request
     * @return JsonResponse
     */
    public function updateAssociationAction(Request $request): JsonResponse
    {
        $content =$request->getContent();
        if (!empty($content))
        {
            $a = new Association();
            $params = json_decode($content,false);
            $a->setId($params->id);
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
            return new JsonResponse($a->getId(), Response::HTTP_OK);
        }
        return new JsonResponse('Page not found.', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route(path="/membership", name="api_association_add",methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addMembershipAction(Request $request): JsonResponse
    {
        $content =$request->getContent();
        if (!empty($content))
        {
            $a = new Adherance();
            $params = json_decode($content,false);
            $a->setUser($this->getDoctrine()->getRepository('AppBundle:User')->find($params->memberId));
            $a->setAssociation($this->getDoctrine()->getRepository('AssociationBundle:Association')->find($params->assId));
            $a->setStatus($params->status);
            $a->setDescription($params->description);
            $a->setLatitude($params->lat);
            $a->setLongitude($params->lon);
            $a->setRole($params->role);
            $a->setFonction($params->fonction);
            $em = $this->getDoctrine()->getManager();
            $em->persist($a);
            $em->flush();
            return new JsonResponse(array("id"=>$a->getId()), Response::HTTP_CREATED);
        }
        return new JsonResponse('Failed.', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route(path="/membership/update", name="api_membership_update",methods={"PATCH"})
     * @param Request $request
     * @return JsonResponse
     */
    public function updateMembershipAction(Request $request): JsonResponse
    {
        $content =$request->getContent();
        if (!empty($content))
        {
            $params = json_decode($content,false);
            $a = $this->getDoctrine()->getRepository('AssociationBundle:Adherance')->find($params->id);
            $a->setStatus($params->status);
            $a->setDescription($params->description);
            $a->setLatitude($params->lat);
            $a->setLongitude($params->lon);
            $a->setRole($params->role);
            $a->setFonction($params->fonction);
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return new JsonResponse('Updated !',Response::HTTP_OK);
        }
        return new JsonResponse('Failed.', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route(path="/membership/delete", name="api_membership_delete",methods={"DELETE"})
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteMembershipAction(Request $request): JsonResponse
    {
        $content =$request->getContent();
        if (!empty($content))
        {
            $params = json_decode($content,false);
            $a = $this->getDoctrine()->getRepository('AssociationBundle:Adherance')->find($params->id);
            $em = $this->getDoctrine()->getManager();
            $em->remove($a);
            $em->flush();
            return new JsonResponse('Deleted !',Response::HTTP_OK);
        }
        return new JsonResponse('Failed.', Response::HTTP_BAD_REQUEST);
    }
}
