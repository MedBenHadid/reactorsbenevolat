<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends Controller
{
    /**
     * @Route(path="/dashboard/admin",name="dashboard_admin_homepage")
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function adminAction(){
        return $this->render('@App/default/index.html.twig');
    }

    /**
     * @Route(path="/dashboard/manager",name="dashboard_manager_homepage")
     * @IsGranted("ROLE_ASSOCIATION_ADMIN")
     */
    public function managerAction(){
        return $this->render('@App/default/index.html.twig');
    }

}
