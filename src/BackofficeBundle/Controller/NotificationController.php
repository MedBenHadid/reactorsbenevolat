<?php

namespace BackofficeBundle\Controller;

use BackofficeBundle\Entity\Notification;
use MissionBundle\Entity\Invitation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Notification controller.
 *
 * @Route("notification")
 */
class NotificationController extends Controller
{


    /**
     * @Route("/list", name="notification_list")
     * @Method("POST")
     * @param Request $request
     * @return Response
     */
    public function listAction(Request $request)
    {
        //  var_dump($request->request->get('data') );
        $manager=$this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array('username'=>$this->getUser()->getUsername()));
        // $notification = $this->getDoctrine()->getRepository('BackofficeBundle:Notification')->findBy(array('id_user'=>$manager->getId()));

        $repository= $this->getDoctrine()->getRepository("BackofficeBundle:Notification");
        $notification=$repository->createQueryBuilder('N')
            ->where('N.id_user > :idUser')
            ->setParameter('idUser', $manager->getId())
            ->orderBy('N.date', 'DESC')
            ->getQuery();

        //$notification->getResult();

        //    $request->request->get('id')
        return new JsonResponse($notification->getResult());
        //  new JsonResponse($this->json($notification));

    }

    /**
     * @Route("/AcceptInvi/{id}", name="notification_AcceptInvi")
     * @Method("POST")
     * @param Request $request
     * @return Response
     */
    public function acceptAction(Request $request)
    {    $entityManager = $this->getDoctrine()->getManager();

        //  var_dump($request->request->get('data') );
        //$manager=$this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array('username'=>$this->getUser()->getUsername()));
         $invi = $entityManager->getRepository('MissionBundle:Invitation')->findOneBy(array('id_notification'=>$request->get('id')));
        $invi->setEtat(Invitation::accepter);
        if (!$invi) {
            throw $this->createNotFoundException(
                'No invitation found for id_notification '.$request->get('id')
            );
        }
        $notification = $entityManager->getRepository('BackofficeBundle:Notification')->findOneBy(array('id'=>$request->get('id')));
        $notification->setSeen(True);
        $entityManager->flush();
        //    $request->request->get('id')
        //  return new JsonResponse($notification->getResult());
        $data = [
            'type' => 'ok',
            'title' => 'accept',
        ];
     return new JsonResponse($data,200);

    }
    /**
     * @Route("/RefuserInvi/{id}", name="notification_RefuserInvi")
     * @Method("POST")
     * @param Request $request
     * @return Response
     */
    public function refuserAction(Request $request)
    {    $entityManager = $this->getDoctrine()->getManager();

        //  var_dump($request->request->get('data') );
        //$manager=$this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array('username'=>$this->getUser()->getUsername()));
        $invi = $entityManager->getRepository('MissionBundle:Invitation')->findOneBy(array('id_notification'=>$request->get('id')));
        $invi->setEtat(Invitation::réfuser);
        if (!$invi) {
            throw $this->createNotFoundException(
                'No invitation found for id_notification '.$request->get('id')
            );
        }
        $notification = $entityManager->getRepository('BackofficeBundle:Notification')->findOneBy(array('id'=>$request->get('id')));
        $notification->setSeen(True);
        $entityManager->flush();
        //    $request->request->get('id')
        //  return new JsonResponse($notification->getResult());
        $data = [
            'type' => 'ok',
            'title' => 'réfuser',
        ];
        return new JsonResponse($data,200);

    }

    /**
     * Lists all notification entities.
     *
     * @Route("/", name="notification_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $manager=$this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array('username'=>$this->getUser()->getUsername()));

        $repository= $this->getDoctrine()->getRepository("BackofficeBundle:Notification");
        $notifications=$repository->createQueryBuilder('N')
            ->where('N.id_user > :idUser')
            ->setParameter('idUser', $manager->getId())
            ->orderBy('N.date', 'DESC')
            ->getQuery();
        return $this->render('@Backoffice/notification/index.html.twig', array(
            'notifications' => $notifications->getResult(),
        ));
    }

    /**
     * Finds and displays a notification entity.
     *
     * @Route("/{id}", name="notification_show")
     * @Method("GET")
     */
    public function showAction(Notification $notification)
    {

        return $this->render('@Backoffice/notification/show.html.twig', array(
            'notification' => $notification,
        ));
    }


}
