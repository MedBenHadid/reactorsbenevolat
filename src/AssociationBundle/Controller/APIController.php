<?php

namespace AssociationBundle\Controller;

use AssociationBundle\Entity\Adherance;
use AssociationBundle\Entity\Association;
<<<<<<< HEAD
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
=======
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
>>>>>>> 828daa075d4193b154f76a7094238bc737adb040
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
<<<<<<< HEAD

=======
>>>>>>> 828daa075d4193b154f76a7094238bc737adb040
/**
 * API controller.
 *
 * @Route("/api")
 */
class APIController extends Controller
{
    /**
<<<<<<< HEAD
     * @Route(path="/association/image/download/{f}", name="api_file_fetch",methods={"GET"})
     * @param $f
     * @return BinaryFileResponse
     */
    public function download($f): BinaryFileResponse
    {
        return new BinaryFileResponse($this->getParameter('association_image_directory') .'/'. $f);
    }

    //issam

    /**
     * @Route(path="/don/image/download/{f}", name="api_fetch_don_image",methods={"GET"})
     * @param $f
     * @return BinaryFileResponse
     */
    public function downloadImageDon($f): BinaryFileResponse
    {
        return new BinaryFileResponse($this->getParameter('donImages_directory') .'/'. $f);
    }



    /**
     * @Route(path="/demande/image/download/{f}", name="api_fetch_demande_image",methods={"GET"})
     * @param $f
     * @return BinaryFileResponse
     */
    public function downloadImageDemande($f): BinaryFileResponse
    {
        return new BinaryFileResponse($this->getParameter('donImages_directory') .'/'. $f);
    }




    /**
     * @Route(path="/don/upload/image", name="api_don_image_upload",methods={"POST"})
=======
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
>>>>>>> 828daa075d4193b154f76a7094238bc737adb040
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadImageAction(Request $request): JsonResponse
    {
<<<<<<< HEAD
        $s = $request->files->get('file')->move($this->getParameter('donImages_directory').'/', $request->get('filename'));
        return new JsonResponse(array('message'=>'ok'),Response::HTTP_OK);
    }


 //issam wffé
    /**
     * @Route(path="/upload", name="api_file_upload",methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function upload(Request $request): JsonResponse
    {
        $content =$request->getContent();
        if (!empty($content))
        {
            $params = json_decode($content,false);
            $uuid = Uuid::uuid1();
            /** @var File $data */
            $data = base64_decode($params->file);
            $data->move($this->getParameter('root').$params->path, $uuid);
            //throw new HttpException(500, 'Caught exception: No file to upload');
            return new JsonResponse($uuid->jsonSerialize(),Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse('Failed to upload',Response::HTTP_BAD_REQUEST);
    }
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
=======
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


>>>>>>> 828daa075d4193b154f76a7094238bc737adb040
    /**
     * @Route(path="/associations/findoneby/manager/{managerId}", name="api_association_lookup_by_manager", methods={"GET"})
     * @param $managerId
     * @return JsonResponse
     */
    public function lookupAssociationByManagerAction($managerId): JsonResponse
    {
<<<<<<< HEAD
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(static function ($object) {return $object->getId();});
        $serializer = new Serializer(array($normalizer), array(new JsonEncoder()));
        return new JsonResponse($serializer->normalize($this->getDoctrine()->getRepository('AssociationBundle:Association')->findOneBy(['manager' => $managerId])));
=======
        return new JsonResponse($this->serializer->normalize($this->getDoctrine()->getRepository('AssociationBundle:Association')->findOneBy(['manager' => $managerId])));
>>>>>>> 828daa075d4193b154f76a7094238bc737adb040
    }
    /**
     * @Route(path="/association/{id}", name="api_association_lookup_by_id", methods={"GET"})
     * @param $id
     * @return JsonResponse
     */
    public function lookupAssociationByIdAction($id): JsonResponse
    {
<<<<<<< HEAD
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(static function ($object) {return $object->getId();});
        $serializer = new Serializer(array($normalizer), array(new JsonEncoder()));
        return new JsonResponse($serializer->normalize($this->getDoctrine()->getRepository('AssociationBundle:Association')->find($id)));
=======
        return new JsonResponse($this->serializer->normalize($this->getDoctrine()->getRepository('AssociationBundle:Association')->find($id)));
>>>>>>> 828daa075d4193b154f76a7094238bc737adb040
    }

    /**
     * @Route(path="/domaines", name="api_domaines_paginated", methods={"GET"})
     * @return JsonResponse
     */
    public function domainesAction(): JsonResponse
    {
<<<<<<< HEAD
        $serializer = new Serializer(array(new ObjectNormalizer()), array(new JsonEncoder()));
        return new JsonResponse($serializer->normalize($this->getDoctrine()->getRepository('AssociationBundle:Category')->findAll()));
=======
        return new JsonResponse($this->serializer->normalize($this->getDoctrine()->getRepository('AssociationBundle:Category')->findAll()));
>>>>>>> 828daa075d4193b154f76a7094238bc737adb040
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
<<<<<<< HEAD
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(static function ($object) {return $object->getId();});
        $serializer = new Serializer(array($normalizer), array(new JsonEncoder()));
        if( $status=="ALL")
            return new JsonResponse($serializer->normalize($this->getDoctrine()->getRepository('AssociationBundle:Adherance')->findAll()));
=======
        if( $status=='ALL')
            return new JsonResponse($this->serializer->normalize($this->getDoctrine()->getRepository('AssociationBundle:Adherance')->findAll()));
>>>>>>> 828daa075d4193b154f76a7094238bc737adb040
        else if ($oneForAssociation==1)
            $query = 'SELECT m FROM AssociationBundle:Adherance m WHERE m.association = :id AND m.status = :status ';
        else
            $query = 'SELECT m FROM AssociationBundle:Adherance m WHERE m.user = :id AND m.status = :status ';
        $query = $this->getDoctrine()->getManager()->createQuery($query)->setParameter('id',$id)->setParameter('status',$status);

<<<<<<< HEAD
        return new JsonResponse($serializer->normalize($query->execute()));
=======
        return new JsonResponse($this->serializer->normalize($query->execute()));
>>>>>>> 828daa075d4193b154f76a7094238bc737adb040
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
<<<<<<< HEAD
=======
            // TODO : Check for name exists (name and approved query)
>>>>>>> 828daa075d4193b154f76a7094238bc737adb040
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
<<<<<<< HEAD
 
=======

>>>>>>> 828daa075d4193b154f76a7094238bc737adb040
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
<<<<<<< HEAD
            $a->setId($params->id);
=======
>>>>>>> 828daa075d4193b154f76a7094238bc737adb040
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
<<<<<<< HEAD
            return new JsonResponse($a->getId(), Response::HTTP_OK);
        }
        return new JsonResponse('Page not found.', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route(path="/membership", name="api_association_add",methods={"POST"})
=======
            return new JsonResponse('Updated', Response::HTTP_OK);
        }
        return new JsonResponse('failed ?.', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route(path="/membership", name="api_membership_add",methods={"POST"})
>>>>>>> 828daa075d4193b154f76a7094238bc737adb040
     * @param Request $request
     * @return JsonResponse
     */
    public function addMembershipAction(Request $request): JsonResponse
    {
        $content =$request->getContent();
        if (!empty($content))
        {
<<<<<<< HEAD
            $a = new Adherance();
            $params = json_decode($content,false);
            $a->setUser($this->getDoctrine()->getRepository('AppBundle:User')->find($params->memberId));
            $a->setAssociation($this->getDoctrine()->getRepository('AssociationBundle:Association')->find($params->assId));
            $a->setStatus($params->status);
            $a->setDescription($params->description);
=======
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
>>>>>>> 828daa075d4193b154f76a7094238bc737adb040
            $a->setLatitude($params->lat);
            $a->setLongitude($params->lon);
            $a->setRole($params->role);
            $a->setFonction($params->fonction);
            $em = $this->getDoctrine()->getManager();
            $em->persist($a);
            $em->flush();
            return new JsonResponse(array("id"=>$a->getId()), Response::HTTP_CREATED);
        }
<<<<<<< HEAD
        return new JsonResponse('Failed.', Response::HTTP_BAD_REQUEST);
=======
        return new JsonResponse('Failed due to empty request.', Response::HTTP_BAD_REQUEST);
>>>>>>> 828daa075d4193b154f76a7094238bc737adb040
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
<<<<<<< HEAD
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
=======
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
>>>>>>> 828daa075d4193b154f76a7094238bc737adb040
    }

    /**
     * @Route(path="/membership/delete/{id}", name="api_membership_delete",methods={"DELETE"})
<<<<<<< HEAD
     * @param Request $request
=======
     * @param $id
>>>>>>> 828daa075d4193b154f76a7094238bc737adb040
     * @return JsonResponse
     */
    public function deleteMembershipAction($id): JsonResponse
    {
        $a = $this->getDoctrine()->getRepository('AssociationBundle:Adherance')->find($id);
<<<<<<< HEAD
        $em = $this->getDoctrine()->getManager();
        $em->remove($a);
        $em->flush();
        return new JsonResponse('Deleted !',Response::HTTP_OK);
    }
}
=======
        if(!$a) {
            return new JsonResponse('No membership under the id given!', Response::HTTP_BAD_REQUEST);
        }
        $this->getDoctrine()->getManager()->remove($a);
        $this->getDoctrine()->getManager()->flush();
        return new JsonResponse('Deleted !',Response::HTTP_OK);
    }
}
>>>>>>> 828daa075d4193b154f76a7094238bc737adb040
