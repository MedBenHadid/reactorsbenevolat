<?php

namespace MissionBundle\Controller\MobileMissionAPI;

use AssociationBundle\Entity\Association;
use BackofficeBundle\Entity\Notification;
use MissionBundle\Entity\Invitation;
use MissionBundle\Entity\Mission;
use MissionBundle\Entity\Up;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use function Sodium\add;

/**
 * Mission controller.
 *
 * @Route("/missionApi")
 *

 */
class MissionAPIController extends Controller
{




    /**
     * @Route(path="/showAll/{page}/{title}/{location}", defaults={"title":"","location":"","page":1}, name="api_mission_showAll", methods={"GET"}, requirements={"page"="\d+"})
     * @param String $title
     * @param String $location
     * @param int $page
     * @param Request $request
     * @return JsonResponse
     */
    public function showAllAction(Request $request,String $title, String $location,String $page)
    {


        //     $repository= $this->getDoctrine()->getRepository("MissionBundle:Mission");
        //   $missions=$repository->createQueryBuilder('M')
        //      ->orderBy('M.id', 'DESC')
        //    ->getQuery()->getResult();
//var_dump($request->get("association"));
        $res=new Serializer([new ObjectNormalizer()]);
        $formatted =$res->normalize($this->get('knp_paginator')->paginate($this->getDoctrine()->getManager()->createQuery('SELECT m FROM MissionBundle:Mission m WHERE m.titleMission LIKE :Title AND m.location LIKE :location AND m.CreatedBy = :ass')->setParameter('ass',$request->get("association"))->setParameter('Title',$title.'%')->setParameter('location',$location.'%'), $page, 5));
        return new JsonResponse($formatted);

    }

    /**
     * @Route(path="/addMission", name="api_mission_add")
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     * @Method({"GET", "POST"})
     */
    public function addMissionAction(Request $request)
    {
        //$date = \DateTime::createFromFormat('Y-m-d', $request->get("DateCreation"));
        $DateCreation = new \DateTime($request->get("DateCreation"));
        $DateFin = new \DateTime($request->get("DateFin"));

   //    var_dump($request->get("domaine"));

            $em = $this->getDoctrine()->getManager();

            $mission = new Mission();
            $mission->setDomaine($this->getDoctrine()->getRepository('AssociationBundle:Category')->findOneBy(array('id'=>$request->get("domaine"))));
            $mission->setSumCollected(0);
            $mission->setUps(0);
            //$mission->setCreatedBy($this->getUser());
            $mission->setLatitude($request->get("lat"));
            $mission->setLongitude($request->get("lon"));
            $mission->setPicture($request->get("picture"));
            $mission->setTitleMission($request->get("TitleMission"));
            $mission->setDescription($request->get("description"));
            $mission->setObjectif($request->get("objectif"));
            $mission->setLocation($request->get("location"));

        $mission->setDateCreation($DateCreation);
            $mission->setDateFin($DateFin);
            $member=$em->getRepository('AppBundle:User')->findOneBy(array('id'=>74));
            $mission->setCreatedBy($member);

            $em->persist($mission);
            $em->flush();
            return new JsonResponse(1, Response::HTTP_CREATED);

    }
    /**
 * Displays a form to edit an existing mission entity.
 *
 * @Route("/editMission", name="mission_edit")
 * @Method({"GET", "POST"})
 */
    public function editAction(Request $request)
    {

        $DateCreation = new \DateTime($request->get("DateCreation"));
        $DateFin = new \DateTime($request->get("DateFin"));

        $mission = new Mission();

        $em = $this->getDoctrine()->getManager();
        $entityManager = $this->getDoctrine()->getManager();
        $mission = $entityManager->getRepository('MissionBundle:Mission')->find($request->get("id"));

        if (!$mission) {
            throw $this->createNotFoundException(
                'No product found for id '.$mission
            );
        }
           // $mission->setPicture($mission->getPicture());
        if($request->get("domaine")!=0){
            $mission->setDomaine($this->getDoctrine()->getRepository('AssociationBundle:Category')->findOneBy(array('id'=>$request->get("domaine"))));

        }
        $mission->setSumCollected(0);
        $mission->setUps(0);
        //$mission->setCreatedBy($this->getUser());
        $mission->setLatitude($request->get("lat"));
        $mission->setLongitude($request->get("lon"));
       // $mission->setPicture($request->get("picture"));
        $mission->setTitleMission($request->get("TitleMission"));
        $mission->setDescription($request->get("description"));
        $mission->setObjectif($request->get("objectif"));
        $mission->setLocation($request->get("location"));

        $mission->setDateCreation($DateCreation);
        $mission->setDateFin($DateFin);
        $member=$em->getRepository('AppBundle:User')->findOneBy(array('id'=>74));
        $mission->setCreatedBy($member);

        $em->persist($mission);
        $em->flush();
        return new JsonResponse(1, Response::HTTP_CREATED);
    }

    /**
     * @Route(path="/deleteMission", name="api_mission_delete",methods={"DELETE"})
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteAction(Request $request): JsonResponse
    {
        $content =$request->getContent();


            $params = json_decode($content,false);
            $M = $this->getDoctrine()->getRepository('MissionBundle:Mission')->find($request->get('id'));
            $em = $this->getDoctrine()->getManager();
            $em->remove($M);
            $em->flush();
            return new JsonResponse($request->get('id'),Response::HTTP_OK);

    }

    /**
     * @Route(path="/Fetchimage/{name}", name="mission_fetch_image",methods={"GET"})
     * @param $name
     * @return BinaryFileResponse
     */
    public function fetchImage($name): BinaryFileResponse
    {
        return new BinaryFileResponse($this->getParameter('mission_image_directory'). '/' .$name);
    }
}
