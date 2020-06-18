<?php

namespace MissionBundle\Controller\MobileMissionAPI;

use AssociationBundle\Entity\Adherance;
use AssociationBundle\Entity\Association;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * API controller.
 *
 * @Route("/api/user/")
 */
class ApiUserController extends Controller
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var AuthenticationManagerInterface
     */
    private $authenticationManager;

    /**
     * @var string Uniquely identifies the secured area
     */
    private $providerKey;
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * APIController constructor.
     */
    public function __construct()
    {
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(static function ($object) {return $object->getId();});
        $this->serializer = new Serializer(array($normalizer), array(new JsonEncoder()));
    }

    /**
     * @Route(path="profileimage/{imageName}", name="api_profile_image_fetch",methods={"GET"})
     * @param $imageName
     * @return BinaryFileResponse
     */
    public function downloadProfilePictureAction($imageName): BinaryFileResponse
    {
        return new BinaryFileResponse($this->getParameter('user_image_directory') .'/'. $imageName);
    }

    /**
     * @Route(path="{id}", name="api_user_get", methods={"GET"})
     * @param $id
     * @return JsonResponse
     */
    public function lookupUserByIdAction($id): JsonResponse
    {
        return new JsonResponse($this->serializer->normalize($this->getDoctrine()->getRepository('AppBundle:User')->find($id)));
    }

    /**
     * @Route(path="login", name="api_login", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function loginAction(Request $request): JsonResponse
    {
        $password= $request->get('password') ;
        $cred =  $request->get('username');
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array('username'=>$cred));

        if(!empty($user)){
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            return new JsonResponse($this->serializer->normalize(array('user'=>$user,'canLogin'=>$encoder->isPasswordValid($user->getPassword(),$password,$user->getSalt()))), Response::HTTP_OK);
        }else{
            return new JsonResponse($this->serializer->normalize(array('canLogin'=>false)), Response::HTTP_OK);
        }
    }


}
