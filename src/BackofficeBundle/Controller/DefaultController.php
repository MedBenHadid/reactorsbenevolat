<?php

namespace BackofficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package BackofficeBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @Route("/dashboard/admin/users", name="backend",methods={"GET"})
     */
    public function backAction()
    {
        return $this->render('@Backoffice/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    }
