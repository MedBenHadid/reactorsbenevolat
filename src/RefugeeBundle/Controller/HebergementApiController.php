<?php

namespace RefugeeBundle\Controller;

use RefugeeBundle\Entity\Hebergement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Hebergement controller.
 *
 */
class HebergementApiController extends Controller
{
    /**
     * Lists all hebergement entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $hebergements = $em->getRepository('RefugeeBundle:Hebergement')->findAll();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($hebergements);
        return new JsonResponse($formatted);
    }

    /**
     * Creates a new hebergement entity.
     *
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $hebergement = new Hebergement();
        $hebergement->setCreationDate(new \DateTime());
        $hebergement->setDescription($request->get('description'));
        $hebergement->setGovernorat($request->get('governorat'));
        $hebergement->setTelephone($request->get('telephone'));

        //image upload
        $imageFile = $request->files->get('image');
        $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

        try
        {
            $imageFile->move(
                $this->getParameter('hebergementImages_directory'),
                $newFilename
            );
        } catch (FileException $e)
        {
            echo $e->getMessage();
        }

        $hebergement->setImage($newFilename);

        $hebergement->setNbrRooms($request->get('nbr-rooms'));
        $hebergement->setDuration($request->get('duration'));
        $hebergement->setState(0);
        $userId = $request->get('user-id');
        $user = $em->getRepository('AppBundle:User')->find($userId);
        $hebergement->setUser($user);
        $em->persist($hebergement);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($hebergement);

        return new JsonResponse($formatted);
    }

    /**
     * Displays a form to edit an existing hebergement entity.
     *
     */
    public function editAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $hebergement = $this->getDoctrine()
                            ->getManager()
                            ->getRepository('RefugeeBundle:Hebergement')
                            ->find($request->get('id'));

        $hebergement->setDescription($request->get('description'));
        $hebergement->setGovernorat($request->get('governorat'));
        $hebergement->setTelephone($request->get('telephone'));

        //image upload
        $imageFile = $request->files->get('image');
        $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

        try
        {
            $imageFile->move(
                $this->getParameter('hebergementImages_directory'),
                $newFilename
            );
        } catch (FileException $e)
        {
            echo $e->getMessage();
        }

        $hebergement->setImage($newFilename);

        $hebergement->setNbrRooms($request->get('nbr-rooms'));
        $hebergement->setDuration($request->get('duration'));
        $hebergement->setState(0);
        $userId = $request->get('user-id');
        $user = $em->getRepository('AppBundle:User')->find($userId);
        $hebergement->setUser($user);
        $em->persist($hebergement);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($hebergement);
        return new JsonResponse($formatted);
    }

    /**
     * Finds and displays a hebergement entity.
     *
     */
    public function showAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $hebergement = $em->getRepository('RefugeeBundle:Hebergement')->find($request->get('id'));

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($hebergement);
        return new JsonResponse($formatted);
    }


    /**
     * Deletes a hebergement entity.
     *
     */
    public function deleteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $hebergement = $em->getRepository('RefugeeBundle:Hebergement')->find($request->get('id'));
        $em->remove($hebergement);
        $em->flush();
        return new JsonResponse('Hebergement deleted');
    }


}
