<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class UserController
 * @package AppBundle\Controller
 * @Route("/back/users")
 * @IsGranted("ROLE_SUPER_ADMIN")
 */
class UserController extends Controller
{
    /**
     * @Route("/")
     */
    public function listAction()
    {
        return $this->render('AppBundle:User:list.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/show")
     */
    public function showAction()
    {
        return $this->render('AppBundle:User:list.html.twig', array(
            // ...
        ));
    }

}
