<?php


namespace CommunicationBundle\Controller;


use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ApiCommunicationController  extends Controller
{
    public function registerAction(Request $request)
    {

        $user= new User();

        $user->setNom($request->get('nom'));
        $user->setPrenom($request->get('prenom'));
        $user->setUsername($request->get('username'));
        $mailC=$request->get('email');
        $user->setEmailCanonical($mailC);
        $useC=$request->get('username');
        $user->setUsernameCanonical($useC);
        $user->setEnabled(true);

        $user->setPassword($request->get('password'));
        $user->setEmail($request->get('email'));







        $em = $this->getDoctrine()->getManager();

        $em->persist($user);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }
        public  function chercherUserAction($username){

        $em=$this->getDoctrine()->getManager();
        $tasks="0";
        $news =$em->getRepository(User::class)->findBy(array('username'=>$username));
        if (sizeof($news)>0){

            $tasks="1";

        }
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);

    }
    public function chercherUserMailAction($email){


        $em=$this->getDoctrine()->getManager();
        $tasks="0";
        $news =$em->getRepository(User::class)->findBy(array('email'=>$email));
        if (sizeof($news)>0){

            $tasks="1";

        }
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);

    }
    public function findAction($id)
    {

        $tasks = $this->getDoctrine()->getManager()
            ->getRepository(User::class)
            ->findOneBy(['username' => $id]);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

}