<?php

namespace RestApiBundle\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use JMS\SerializerBundle\JMSSerializerBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class HebergementsController extends AbstractFOSRestController
{
//    public function indexAction()
//    {
//        return $this->render('RestApiBundle:Default:index.html.twig');
//    }

      public function getHebergementsAction()
      {
          $em = $this->getDoctrine()->getManager();
          $data = $em->getRepository('RefugeeBundle:Hebergement')->findAll();
          $view = $this->view($data);
          return $this->handleView($view);
      }
}
