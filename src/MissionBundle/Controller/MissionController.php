<?php

namespace MissionBundle\Controller;

use BackofficeBundle\Entity\Notification;
use MissionBundle\Entity\Mission;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * Mission controller.
 *
 * @Route("/mission")
 */
class MissionController extends Controller
{
    /**
     * Lists all mission entities.
     *
     * @Route("/", name="mission_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $missions = $em->getRepository('MissionBundle:Mission')->findAll();

        return $this->render('@Mission/mission/index.html.twig', array(
            'missions' => $missions,
        ));
    }

    /**
     * Creates a new mission entity.
     *
     * @Route("/new", name="mission_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $mission = new Mission();
        $form = $this->createForm('MissionBundle\Form\MissionType', $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



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

                  $em = $this->getDoctrine()->getManager();
                  $em->persist($mission);
                  $em->flush();

            //Persist Notification
            $notification=new Notification();
            $notification->setTitle($mission->getTitleMission())
                ->setDescription($mission->getDescription())
                ->setRoute('mission_show')
                ->setParameters(array('id'=>$mission->getId()));
            $em->persist($notification);

            $em->flush();
            $pusher = $this->get('mrad.pusher.notificaitons');
            $pusher->trigger($notification);

                  return $this->redirectToRoute('mission_show', array('id' => $mission->getId()));
              }

              return $this->render('@Mission/mission/new.html.twig', array(
                  'mission' => $mission,
                  'form' => $form->createView(),
              ));
          }

          /**
           * Finds and displays a mission entity.
           *
           * @Route("/{id}", name="mission_show")
           * @Method("GET")
           */
    public function showAction(Mission $mission)
    {
        $deleteForm = $this->createDeleteForm($mission);

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
