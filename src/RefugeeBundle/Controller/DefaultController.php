<?php

namespace RefugeeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('RefugeeBundle:Default:index.html.twig');
    }
}
