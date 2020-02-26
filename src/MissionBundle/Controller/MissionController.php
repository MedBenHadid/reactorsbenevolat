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
 * @Route("/mission")
 *

 */
class MissionController extends Controller
{

    /**
     * @Route("/notification", name="notification")
     * @Method("POST")
     * @param Request $request
     * @return Response
     */
    public function notificationAction(Request $request)
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
     *
     * @Route("/searchMembers", name="search_member")
     * @Method("POST")
     */
    public function searchAction(Request $request)
    {
        $searchTerm = $request->query->get('search');

        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('User')->findBy(array('username'=>$this->getUser()->getUsername()));//RETERN USER CONNECTED
        $association = $this->getDoctrine()->getRepository('AssociationBundle:Association')->findOneBy(array('manager'=>$user));
        var_dump($association->getMembers());
        $search = $em->getRepository('Association:Classified')->findAll();

        $results = $search->getResult();

        $content = $this->renderView('search-result.html.twig', [
            'results' => $results
        ]);

        $response = new JsonResponse();
        $response->setData(array('classifiedList' => $content));
        return $response;
    }





    /**
     * Lists all mission entities.
     *
     * @Route("/", name="mission_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $manager=$em->getRepository('AppBundle:User')->findOneBy(array('username'=>$this->getUser()->getUsername()));
       //var_dump($this->getUser()->getRoles() );
        if(in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles())){
            $repository= $this->getDoctrine()->getRepository("MissionBundle:Mission");
            $missions=$repository->createQueryBuilder('M')
                ->orderBy('M.id', 'DESC')
                ->getQuery()->getResult();
        }else{
            $repository= $this->getDoctrine()->getRepository("MissionBundle:Mission");
            $missions=$repository->createQueryBuilder('M')
                ->where('M.CreatedBy = :idUser')
                ->setParameter('idUser', $manager->getId())
                ->orderBy('M.id', 'DESC')
                ->getQuery()->getResult();        //   var_dump($missions[0]->getId());
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



     return $this->render('@Mission/mission/index.html.twig', array(
           'missions' => $missions,
      ));
    }

    /**
     * Creates a new mission entity.
     * @Route("/new", name="mission_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param $member
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $mission = new Mission();
        $form = $this->createForm('MissionBundle\Form\MissionType', $mission);
       // if(in_array("ROLE_SUPER_ADMIN", $this->getUser()->getRoles())){
       // }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //var_dump();


            /*      $filePh = $form->getData();

                  $imgExtension = $filePh->guessExtension();
                  $imgNameWithoutSpace = str_replace(' ', '', $filePh);
                  $imgName = $imgNameWithoutSpace . "." . $imgExtension;
                  $filePh->move($this->getParameter('mission_image_directory'), $imgName);
                  $mission->setPicture('client/images/mission/' .$imgName);*/



                /** @var UploadedFile $MissionPic */
            $MissionPic = $form->get('picture_mission')->getData();

                // this condition is needed because the 'brochure' field is not required
                // so the PDF file must be processed only when a file is uploaded
                if ($MissionPic) {
                    $originalFilename = pathinfo($MissionPic->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$MissionPic->guessExtension();

                    // Move the file to the directory where brochures are stored
                    try {
                        $MissionPic->move(
                            $this->getParameter('mission_image_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }

                    // updates the 'brochureFilename' property to store the PDF file name
                    // instead of its contents
                    $mission->setPicture($newFilename);
                }
                  $mission->setSumCollected(0);
                  $mission->setUps(0);
                  $mission->setCreatedBy($this->getUser());
                  $mission->setLatitude($request->request->get('lat_mission'));
                  $mission->setLongitude($request->request->get('lng_mission'));
                  $em = $this->getDoctrine()->getManager();

                  $em->persist($mission);
                  $em->flush();

                  $manager=$this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array('username'=>$this->getUser()->getUsername()));
                $association = $this->getDoctrine()->getRepository('AssociationBundle:Association')->findOneBy(array('manager'=>$manager->getId()));
               //var_dump($manager->getId());
                ///Persist Notification
            $TabMembers = explode(",", $request->request->get('hidden_members'));

         //    var_dump($TabMembers);
            for ($i = 0;$i<sizeof($TabMembers) ; $i++) {
                $memberInv=$em->getRepository('AppBundle:User')->findOneBy(array('id'=>$TabMembers[$i]));
                $notification=new Notification();
                $notification->setTitle($mission->getTitleMission())
                    ->setDescription($mission->getDescription())
                    ->setRoute('notification_show')
                    ->setParameters(array('id'=>$mission->getId()));
                $notification->setIdUser($memberInv);
                $notification->setIdAssociation($association);
                $notification->setIdMission($mission);




                $invitation=new Invitation();
                $invitation->setIdMission($mission);
                $invitation->setIdNotification($notification);
                $invitation->setIdUser($memberInv);
                $notification->setIdInvitation($invitation);
                $em->persist($notification);

                $em->persist($invitation);




                $em->flush();
                //$notification->setIdUser(1);
                $pusher = $this->get('mrad.pusher.notificaitons');
                $pusher->trigger($notification);
                }



           return $this->redirectToRoute('mission_show', array('id' => $mission->getId()));
              }
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findBy(array('username'=>$this->getUser()->getUsername()));//RETERN USER CONNECTED
        $association = $this->getDoctrine()->getRepository('AssociationBundle:Association')->findOneBy(array('manager'=>$user));
      // var_dump($association->getMembers());

              return $this->render('@Mission/mission/new.html.twig', array(
                  'mission' => $mission,
                  'form' => $form->createView(),
                  'users' =>$association->getMembers(),

              ));
          }

          /**
           * Finds and displays a mission entity.
           *
           * @Route("/{id}", name="mission_show")
           * @Method("GET")
           */
    public function showAction(Request $request,Mission $mission)
    {

        //$repository= $this->getDoctrine()->getRepository("MissionBundle:Invitation");
        // $members=$repository->createQueryBuilder('M')
            //->where('M.id_mission = :id_mission')
            //->where('M.etat = accepter')
           // ->setParameter('id_mission', $mission)
          //  ->getQuery()->getResult();



        // $em = $this->getDoctrine()->getManager();

        //   $query = $em->createQuery('SELECT u FROM MissionBundle:Invitation u WHERE u.age > 20');
     //   $members = $query->getResult();


        $deleteForm = $this->createDeleteForm($mission);

        $members = $this->getDoctrine()->getRepository('MissionBundle:Invitation')->findBy(array('id_mission'=>$mission,'etat'=>'accepter'));
        foreach ($members as $member){
            var_dump($member->getIdUser()->getUsername());
        }



        var_dump($members);
        return $this->render('@Mission/mission/show.html.twig', array(
            'mission' => $mission,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mission entity.
     *
     * @Route("/{id}/edit", name="mission_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Mission $mission)
    {
        $deleteForm = $this->createDeleteForm($mission);
        $editForm = $this->createForm('MissionBundle\Form\MissionType', $mission);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mission_edit', array('id' => $mission->getId()));
        }

        return $this->render('@Mission/mission/edit.html.twig', array(
            'mission' => $mission,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mission entity.
     *
     * @Route("/delete/{id}", name="mission_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Mission $mission)
    {
        $em = $this->getDoctrine()->getManager();

       // $notifications=$em->getRepository('BackofficeBundle:Notification')->findOneBy(array('id_mission'=>$mission->getId()));
        $notifications=$em->createQuery('DELETE BackofficeBundle:Notification n WHERE n.id_mission ='.$mission->getId());
        $notifications->execute();


        // $em = $this->getDoctrine()->getManager();
     //   var_dump($notification);
        $em->remove($mission);
         $em->flush();


        return $this->redirectToRoute('mission_index');
    }

    /**
     * Creates a form to delete a mission entity.
     *
     * @param Mission $mission The mission entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Mission $mission)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mission_delete', array('id' => $mission->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
