<?php

namespace AssociationBundle\Controller;

use AssociationBundle\Entity\Adherance;
use AssociationBundle\Entity\Association;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @var Serializer
     */
    private $serializer;

    /**
     * APIController constructor.
     */
    public function __construct()
    {
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(static function ($object) {return $object->getId();});
        $this->serializer = new Serializer(array($normalizer), array(new JsonEncoder()));
    }

    /**
     * @Route(path="/association/image/download/{imageName}", name="api_file_fetch",methods={"GET"})
     * @param $imageName
     * @return BinaryFileResponse
     */
    public function downloadImageAction($imageName): BinaryFileResponse
    {
        return new BinaryFileResponse($this->getParameter('association_image_directory') .'/'. $imageName);
    }

    /**
     * @Route(path="/association/upload/image", name="api_association_image_upload",methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadImageAction(Request $request): JsonResponse
    {
        $s = $request->files->get('file')->move($this->getParameter('association_image_directory').'/', $request->get('filename'));
        return new JsonResponse($s,Response::HTTP_OK);
    }

    /**
     * @Route(path="/association/upload/image", name="api_association_file_upload",methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadFileAction(Request $request): JsonResponse
    {
        $s = $request->files->get('file')->move($this->getParameter('pieces_directory').'/', $request->get('filename'));
        return new JsonResponse($s,Response::HTTP_OK);
    }

    /**
     * @Route(path="/associations", name="api_association_all", methods={"GET"})
     * @return JsonResponse
     */
    public function associationsAction(): JsonResponse
    {
        return new JsonResponse($this->serializer->normalize($this->getDoctrine()->getRepository('AssociationBundle:Association')->findBy(array('approuved'=>true))));
    }

    /**
     * @Route(path="/associations/{page}", name="api_association_paginated", methods={"GET"})
     * @param $page
     * @return JsonResponse
     */
    public function associationsPaginatedAction($page): JsonResponse
    {
        return new JsonResponse($this->serializer->normalize($this->get('knp_paginator')->paginate($this->getDoctrine()->getManager()->createQuery('SELECT a FROM AssociationBundle:Association a WHERE a.approuved=true'), $page, 5)));
    }


    /**
     * @Route(path="/associations/findoneby/manager/{managerId}", name="api_association_lookup_by_manager", methods={"GET"})
     * @param $managerId
     * @return JsonResponse
     */
    public function lookupAssociationByManagerAction($managerId): JsonResponse
    {
        return new JsonResponse($this->serializer->normalize($this->getDoctrine()->getRepository('AssociationBundle:Association')->findOneBy(['manager' => $managerId])));
    }
    /**
     * @Route(path="/association/{id}", name="api_association_lookup_by_id", methods={"GET"})
     * @param $id
     * @return JsonResponse
     */
    public function lookupAssociationByIdAction($id): JsonResponse
    {
        return new JsonResponse($this->serializer->normalize($this->getDoctrine()->getRepository('AssociationBundle:Association')->find($id)));
    }

    /**
     * @Route(path="/domaines", name="api_domaines_paginated", methods={"GET"})
     * @return JsonResponse
     */
    public function domainesAction(): JsonResponse
    {
        return new JsonResponse($this->serializer->normalize($this->getDoctrine()->getRepository('AssociationBundle:Category')->findAll()));
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
        if( $status=='ALL')
            return new JsonResponse($this->serializer->normalize($this->getDoctrine()->getRepository('AssociationBundle:Adherance')->findAll()));
        else if ($oneForAssociation==1)
            $query = 'SELECT m FROM AssociationBundle:Adherance m WHERE m.association = :id AND m.status = :status ';
        else
            $query = 'SELECT m FROM AssociationBundle:Adherance m WHERE m.user = :id AND m.status = :status ';
        $query = $this->getDoctrine()->getManager()->createQuery($query)->setParameter('id',$id)->setParameter('status',$status);

        return new JsonResponse($this->serializer->normalize($query->execute()));
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
            // TODO : Check for name exists (name and approved query)
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
            return new JsonResponse('Updated', Response::HTTP_OK);
        }
        return new JsonResponse('failed ?.', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route(path="/membership", name="api_membership_add",methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addMembershipAction(Request $request): JsonResponse
    {
        $content =$request->getContent();
        if (!empty($content))
        {
            $params = json_decode($content,false);
            if(!$params->memberId||!$params->assId){
                return new JsonResponse('Wrong paramaters',Response::HTTP_BAD_REQUEST);
            }
            if($member = $this->getDoctrine()->getRepository('AppBundle:User')->find($params->memberId)){
                return new JsonResponse('User not found',Response::HTTP_BAD_REQUEST);
            }
            if($association = $this->getDoctrine()->getRepository('AssociationBundle:Association')->find($params->assId)){
                return new JsonResponse('Association not',Response::HTTP_BAD_REQUEST);
            }
            if($this->getDoctrine()->getRepository('AssociationBundle:Adherance')->findOneBy(array('user'=> $params->memberId,'association'=>$params->assId))){
                return new JsonResponse('Member already subscribed',Response::HTTP_BAD_REQUEST);
            }
            $a = new Adherance();
            $a->setUser($member);
            $a->setAssociation($association);
            $a->setStatus($params->status);
            $a->setDescription($params->description);
            // TODO : Provide default as association Lat and lon
            $a->setLatitude($params->lat);
            $a->setLongitude($params->lon);
            $a->setRole($params->role);
            $a->setFonction($params->fonction);
            $em = $this->getDoctrine()->getManager();
            $em->persist($a);
            $em->flush();
            return new JsonResponse(array("id"=>$a->getId()), Response::HTTP_CREATED);
        }
        return new JsonResponse('Failed due to empty request.', Response::HTTP_BAD_REQUEST);
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
            if($a){
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
        }
        return new JsonResponse('Failed either empty body or no membership found with given id!.', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route(path="/membership/delete/{id}", name="api_membership_delete",methods={"DELETE"})
     * @param $id
     * @return JsonResponse
     */
    public function deleteMembershipAction($id): JsonResponse
    {
        $a = $this->getDoctrine()->getRepository('AssociationBundle:Adherance')->find($id);
        if(!$a) {
            return new JsonResponse('No membership under the id given!', Response::HTTP_BAD_REQUEST);
        }
        $this->getDoctrine()->getManager()->remove($a);
        $this->getDoctrine()->getManager()->flush();
        return new JsonResponse('Deleted !',Response::HTTP_OK);
    }
}