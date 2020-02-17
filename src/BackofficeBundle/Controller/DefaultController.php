<?php

namespace BackofficeBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 * @package BackofficeBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @Route("/back", name="backend")
     */
    public function backAction(Request $request)
    {
        return $this->render('@Backoffice/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}
