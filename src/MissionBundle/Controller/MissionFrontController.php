<?php

namespace MissionBundle\Controller;

use BackofficeBundle\Entity\Notification;
use MissionBundle\Entity\Invitation;
use MissionBundle\Entity\Mission;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use function Sodium\add;

/**
 * Mission controller.
 *
 * @Route("/front/mission")
 *

 */
class MissionFrontController extends Controller
{


    /**
     * Lists all mission entities.
     *
     * @Route("/", name="mission_indexFront")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $manager=$em->getRepository('AppBundle:User')->findOneBy(array('username'=>$this->getUser()->getUsername()));
       //var_dump($this->getUser()->getRoles() );
        //  if(in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles())){
            $missions = $em->getRepository('MissionBundle:Mission')->findAll();
            //  }else{
           //$missions = $em->getRepository('MissionBundle:Mission')->findBy(array('CreatedBy'=>$manager->getId()));


        //   var_dump($missions[0]->getId());

            // }

        $repository= $this->getDoctrine()->getRepository("MissionBundle:Mission");
        $missions=$repository->createQueryBuilder('M')
            ->orderBy('M.id', 'DESC')
            ->getQuery()->getResult();

     return $this->render('@Mission/Default/index.html.twig', array(
           'missions' => $missions,
      ));
    }
    /**
     * Finds and displays a mission entity.
     *
     * @Route("/{id}", name="mission_showFront")
     * @Method("GET")
     */
    public function showAction(Request $request,Mission $mission)
    {


        $members = $this->getDoctrine()->getRepository('MissionBundle:Invitation')->findBy(array('id_mission'=>$mission->getId(),'etat'=>'accepter'));



        // var_dump($members);
        return $this->render('@Mission/Default/show.html.twig', array(
            'mission' => $mission,
            'members'=>$members
        ));
    }

}
