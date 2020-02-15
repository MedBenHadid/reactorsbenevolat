<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AssociationBundle\Entity\Association;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use FOS\UserBundle\Event\GetResponseUserEvent;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;

class RegistrationController extends BaseController
{
    public function registerAction(Request $request)
    {
        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                //return var_dump($request->request->all()['fos_user_registration_form']['plainPassword']['first']);
                $user->setRoles(array(User::USER));
                $user->setRole(User::USER);
                $user->setApprouved(1);
                $user->setMail($request->request->all()['fos_user_registration_form']['email']);
                $user->setPasswordPlain($request->request->all()['fos_user_registration_form']['plainPassword']['first']);
                $userManager->updateUser($user);

                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('fos_user_registration_confirmed');
                    $response = new RedirectResponse($url);
                }

                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
            }

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

            if (null !== $response = $event->getResponse()) {
                return $response;
            }
        }

        return $this->render('@FOSUser/Registration/register.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    public function registerAdminAssociationAction(Request $request)
    {
        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                //return var_dump($request->request->all()['fos_user_registration_form']['plainPassword']['first']);
                $user->setRoles(array(User::ASSOCIATION_ADMIN));
                $user->setRole(User::ASSOCIATION_ADMIN);
                $user->setApprouved(0);
                $user->setEnabled(0);
                $user->setMail($request->request->all()['fos_user_registration_form']['email']);
                $user->setPasswordPlain($request->request->all()['fos_user_registration_form']['plainPassword']['first']);
                $userManager->updateUser($user);

                // AJOUT AGENCE
                $agence = new Association();
                $agence->setNomAssociation($request->request->get('nom_agence'));
                $agence->setTelephoneAssociation($request->request->get('tel_agence'));
                $agence->setTypeAssociation("location");
                $agence->setHoraireTravail($request->request->get('horaire_agence'));

                $filePh = $request->files->get('photo_agence');
                $imgExtension = $request->files->get('photo_agence')->guessExtension();
                $imgNameWithoutSpace = str_replace(' ', '', $request->request->get('nom_agence'));
                $imgName = $imgNameWithoutSpace . "." . $imgExtension;
                $filePh->move($this->getParameter('association_directory'), $imgName);
                $agence->setPhotoAssociation('client/images/associations/' .$imgName);

                $agence->setManager($user);

                $filePh = $request->files->get('piece_agence');
                $imgExtension = $request->files->get('piece_agence')->guessExtension();
                $imgNameWithoutSpace = str_replace(' ', '', $request->request->get('nom_agence'));
                $imgName = $imgNameWithoutSpace . "." . $imgExtension;
                $filePh->move($this->getParameter('pieces_directory'), $imgName);
                $agence->setPieceJustificatif('client/images/associations/pieces/' .$imgName);

                $agence->setRue($request->request->get('rue_agence'));
                $agence->setCodePostal($request->request->get('code_postal_agence'));
                $agence->setVille($request->request->get('ville_agence'));
                $agence->setLatitude($request->request->get('lat_agence'));
                $agence->setLongitude($request->request->get('lng_agence'));


                $em = $this->getDoctrine()->getManager();
                $em->persist($agence);
                $em->flush();

                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('fos_user_registration_confirmed');
                    $response = new RedirectResponse($url);
                }

                //$dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                //return $response;
                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Votre Demande de création agence a eté envoyé avec succée');
                ;
                return $this->redirectToRoute('association_default_index');
            }

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

            if (null !== $response = $event->getResponse()) {
                return $response;
            }
        }

        return $this->render(':default:register_manager_association.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}