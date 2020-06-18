<?php

namespace DonsBundle\Controller;
use DonsBundle\Entity\Demande;
use DonsBundle\Entity\Don;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
class ApiController extends Controller
{
    public function donAction()
    {

//        $don = $this->getDoctrine()->getManager()
//            ->getRepository('DonsBundle\Entity\Don')
//            ->findAll();
//        $serializer = new Serializer([new ObjectNormalizer()]);
//        $formatted = $serializer->normalize($don);
//        return new JsonResponse($formatted);


        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        // Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $encoders = array(new JsonEncoder());
        $serializer = new Serializer($normalizers, $encoders);
        $don = $this->getDoctrine()->getManager()
            ->getRepository('DonsBundle\Entity\Don')
            ->findAll();
        $formatted = $serializer->normalize($don);
        return new JsonResponse($formatted);
    }


    /**
     * Creates a new don entity.
     *
     */
    public function addAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $don = new Don();
        $don->setCreationDate(new \DateTime());
        $don->setTitle($request->get('title'));
        $don->setDescription($request->get('Description'));
        $don->setImage($request->get('image')); // STATIC
        $don->setAddress($request->get('address'));
        $don->setPhone($request->get('phone'));
        $don->setLongitude($request->get('longitude'));
        $don->setLatitude($request->get('latitude'));
        $domaine = $this->getDoctrine()
            ->getManager()
            ->getRepository('AssociationBundle:Category')
            ->find($request->get('domaine'));
        $don->setDomaine($domaine
        );
        $don->setState(0);

        $userId = 1; // STATIC
        $user = $em->getRepository('AppBundle:User')->find($userId);
        $don->setUser($user);
        $don->setUps(0);
        $em->persist($don);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($don);
        return new JsonResponse($formatted, Response::HTTP_OK);
    }
    /**
     * Finds and displays a don entity.
     *
     */
    public function apishowAction(Request $request)
    {
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });

        $normalizers = array($normalizer);
        $encoders = array(new JsonEncoder());
        $em = $this->getDoctrine()->getManager();

        $don = $em->getRepository("DonsBundle:Don")->find($request->get('id'));

        $serializer = new Serializer($normalizers, $encoders);
        $formatted = $serializer->normalize($don);
        return new JsonResponse($formatted);
    }
    /**
     * Deletes a don entity.
     *
     */
    public function removeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $don = $em->getRepository('DonsBundle:Don')->find($request->get('id'));
        $em->remove($don);
        $em->flush();
        return new JsonResponse('Don deleted');
    }



    /**
     * Displays a form to edit an existing hebergement entity.
     *
     */
    public function apieditAction(Request $request)
    {

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });

        $normalizers = array($normalizer);
        $encoders = array(new JsonEncoder());

        $em = $this->getDoctrine()->getManager();

        $don = $this->getDoctrine()
                ->getManager()
                ->getRepository('DonsBundle:Don')
                ->find($request->get('id'));
           $don->setTitle($request->get('title'));
        $don->setDescription($request->get('Description'));
        $don->setImage($request->get('image')); // STATIC
        $don->setAddress($request->get('address'));
        $don->setPhone($request->get('phone'));
        $don->setLongitude($request->get('longitude'));
        $don->setLatitude($request->get('latitude'));
        $don->setState(0);
        $domaine = $this->getDoctrine()
            ->getManager()
            ->getRepository('AssociationBundle:Category')
            ->find($request->get('domaine'));
        $don->setDomaine($domaine);
        $don->setState(0);        $userId = 1; // STATIC
        $user = $em->getRepository('AppBundle:User')->find($userId);
        $don->setUser($user);
        $em->persist($don);
        $em->flush();
        $serializer = new Serializer($normalizers, $encoders);
        $formatted = $serializer->normalize($don);
        return new JsonResponse($formatted);
    }
    public function demandeApiAction()
    {

//        $don = $this->getDoctrine()->getManager()
//            ->getRepository('DonsBundle\Entity\Don')
//            ->findAll();
//        $serializer = new Serializer([new ObjectNormalizer()]);
//        $formatted = $serializer->normalize($don);
//        return new JsonResponse($formatted);


        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        // Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = array($normalizer);
        $encoders = array(new JsonEncoder());
        $serializer = new Serializer($normalizers, $encoders);
        $don = $this->getDoctrine()->getManager()
            ->getRepository('DonsBundle\Entity\Demande')
            ->findAll();
        $formatted = $serializer->normalize($don);
        return new JsonResponse($formatted);
    }


    /**
     * Creates a new don entity.
     *
     */
    public function addDemandeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $demande = new Demande();
        $demande->setCreationDate(new \DateTime());
        $demande->setTitle($request->get('title'));
        $demande->setDescription($request->get('Description'));
        $demande->setImage($request->get('image')); // STATIC
        $demande->setAddress($request->get('address'));
        $demande->setPhone($request->get('phone'));
        $demande->setLongitude($request->get('longitude'));
        $demande->setLatitude($request->get('latitude'));
        $demande->setRib($request->get('rib'));
        $demande->setState(0);

        $userId = 1; // STATIC
        $user = $em->getRepository('AppBundle:User')->find($userId);
        $demande->setUser($user);
        $em->persist($demande);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($demande);
        return new JsonResponse($formatted);
    }

    /**
     * Finds and displays a don entity.
     *
     */
    public function demandeShowAction(Request $request)
    {
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });

        $normalizers = array($normalizer);
        $encoders = array(new JsonEncoder());
        $em = $this->getDoctrine()->getManager();

        $demande = $em->getRepository("DonsBundle:Demande")->find($request->get('id'));

        $serializer = new Serializer($normalizers, $encoders);
        $formatted = $serializer->normalize($demande);
        return new JsonResponse($formatted);
    }

    public function removeDemandeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $demande = $em->getRepository('DonsBundle:Demande')->find($request->get('id'));
        $em->remove($demande);
        $em->flush();
        return new JsonResponse('Don deleted');
    }
}
