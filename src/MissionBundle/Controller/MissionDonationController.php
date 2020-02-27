<?php

namespace MissionBundle\Controller;

use MissionBundle\Entity\MissionDonation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Missiondonation controller.
 *
 * @Route("MissionDonation")
 */
class MissionDonationController extends Controller
{
    /**
     * Lists all missionDonation entities.
     *
     * @Route("/new", name="MissionDonation_new")
     * @Method("POST")
     * @param Request $request
     * @return JsonResponse
     */
    public function newAction(Request $request)
    {


       /** @var $id string */
        $id = $request->request->get('idMission');
        //$id = serialize($request->request->get('idMission'));
        $manager=$this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array('username'=>$this->getUser()->getUsername()));
        $mission=$this->getDoctrine()->getRepository('MissionBundle:Mission')->find($id);

        $em = $this->getDoctrine()->getManager();
        $donation=new MissionDonation();
        $donation->setIdUser($manager);
        $donation->setIdMission($mission);
        $donation->setSommeDonner((int)$request->request->get('dataDonation'));
        $mission->setSumCollected($mission->getSumCollected()+(int)$request->request->get('dataDonation'));
        $em->persist($mission);
        $em->persist($donation);
        $em->flush();
//var_dump($request);
        //  $missionDonations = $em->getRepository('MissionBundle:MissionDonation')->findAll();

        //    return new JsonResponse($notification->getResult());




        return new JsonResponse($request->request->get('idMission'));


    }

    /**
     * Finds and displays a missionDonation entity.
     *
     * @Route("/{id}", name="MissionDonation_show")
     * @Method("GET")
     */
    public function showAction(MissionDonation $missionDonation)
    {

        return $this->render('missiondonation/show.html.twig', array(
            'missionDonation' => $missionDonation,
        ));
    }
}
