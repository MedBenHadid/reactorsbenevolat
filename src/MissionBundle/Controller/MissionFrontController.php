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
        if(in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles())){
            $missions = $em->getRepository('MissionBundle:Mission')->findAll();
        }else{
           //$missions = $em->getRepository('MissionBundle:Mission')->findBy(array('CreatedBy'=>$manager->getId()));

            $repository= $this->getDoctrine()->getRepository("MissionBundle:Mission");
            $missions=$repository->createQueryBuilder('M')
                ->orderBy('M.id', 'DESC')
                ->getQuery()->getResult();
        //   var_dump($missions[0]->getId());
            foreach ($missions as &$value) {
                //select COUNT invitation
                $invi = $em->getRepository('MissionBundle:Invitation')->findBy(array('id_mission'=>$value->getId()));
                $value->invitation =count($invi,COUNT_NORMAL);
                //select COUNT invitation Accepter
                $inviAccpter = $em->getRepository('MissionBundle:Invitation')->findBy(array('id_mission'=>$value->getId(),'etat'=>'accepter'));
                $value->accpter =count($inviAccpter,COUNT_NORMAL);
                //select COUNT invitation refuser
                $inviAccpter = $em->getRepository('MissionBundle:Invitation')->findBy(array('id_mission'=>$value->getId(),'etat'=>'réfuser'));
                $value->refuser =count($inviAccpter,COUNT_NORMAL);
            }
        }



     return $this->render('@Mission/Default/index.html.twig', array(
           'missions' => $missions,
      ));
    }


}
