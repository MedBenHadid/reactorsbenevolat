<?php

namespace RefugeeBundle\Controller;

use RefugeeBundle\Entity\HebergementRequest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Hebergementrequest controller.
 *
 */
class HebergementRequestApiController extends Controller
{
    /**
     * Lists all hebergementRequest entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $hebergementRequests = $em->getRepository('RefugeeBundle:HebergementRequest')->findAll();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($hebergementRequests);
        return new JsonResponse($formatted);
    }

    /**
     * Creates a new hebergementRequest entity.
     *
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $hebergementRequest = new HebergementRequest();
        $hebergementRequest->setCreationDate(new \DateTime());
        $hebergementRequest->setName($request->get('name'));
        $hebergementRequest->setDescription($request->get('description'));
        $hebergementRequest->setNativeCountry($request->get('native-country'));
        $hebergementRequest->setArrivalDate($request->get('arrival-date'));
        $hebergementRequest->setPassportNumber($request->get('passport-number'));
        $hebergementRequest->setCivilStatus($request->get('civil-status'));
        $hebergementRequest->setChildrenNumber($request->get('children-number'));
        $hebergementRequest->setRegion($request->get('region'));
        $hebergementRequest->setTelephone($request->get('telephone'));
        $hebergementRequest->setIsAnonymous($request->get('is-anonymous'));
        $hebergementRequest->setState(0);
        $userId = 72; // STATIC
        $user = $em->getRepository('AppBundle:User')->find($userId);
        $hebergementRequest->setUser($user);
        $em->persist($hebergementRequest);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($hebergementRequest);
        return new JsonResponse($formatted);
    }

    /**
     * Finds and displays a hebergementRequest entity.
     *
     */
    public function showAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $hebergementRequest = $em->getRepository('RefugeeBundle:HebergementRequest')->find($request->get('id'));

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($hebergementRequest);
        return new JsonResponse($formatted);
    }

    /**
     * Displays a form to edit an existing hebergementRequest entity.
     *
     */
    public function editAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $hebergementRequest = $this->getDoctrine()
            ->getManager()
            ->getRepository('RefugeeBundle:HebergementRequest')
            ->find($request->get('id'));

        $hebergementRequest->setName($request->get('name'));
        $hebergementRequest->setDescription($request->get('description'));
        $hebergementRequest->setNativeCountry($request->get('native-country'));
        $hebergementRequest->setArrivalDate($request->get('arrival-date'));
        $hebergementRequest->setPassportNumber($request->get('passport-number'));
        $hebergementRequest->setCivilStatus($request->get('civil-status'));
        $hebergementRequest->setChildrenNumber($request->get('children-number'));
        $hebergementRequest->setRegion($request->get('region'));
        $hebergementRequest->setTelephone($request->get('telephone'));
        $hebergementRequest->setIsAnonymous($request->get('is-anonymous'));
        $userId = $request->get('user-id');
        $user = $em->getRepository('AppBundle:User')->find($userId);
        $hebergementRequest->setUser($user);
        $em->persist($hebergementRequest);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($hebergementRequest);
        return new JsonResponse($formatted);
    }

    /**
     * Deletes a hebergementRequest entity.
     *
     */
    public function deleteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $hebergementRequest = $em->getRepository('RefugeeBundle:HebergementRequest')->find($request->get('id'));
        $em->remove($hebergementRequest);
        $em->flush();
        return new JsonResponse('Hebergement request deleted');
    }
}
