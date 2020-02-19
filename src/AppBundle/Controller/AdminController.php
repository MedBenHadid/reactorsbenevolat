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
















    public function sendMailApprouve($email, $name)
    {
        $message = (new \Swift_Message('Confirmation dassociation'))
            ->setFrom('reactors.info@gmail.com')
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    'AppBundle:Emails:approuver_agence.html.twig',
                    array('name' => $name)
                ),
                'text/html'
            );
        $this->get('mailer')->send($message);



        return $this->render('AppBundle:Emails:approuver_agence.html.twig',array('name'=>$name));
    }

    public function sendMailDesapprouve($email, $name)
    {
        $message = (new \Swift_Message('Rejet de demande de création de compte dassociation'))
            ->setFrom('reactors.info@gmail.com')
            ->setTo($email)
            ->setBody(
                $this->renderView(
                '@App/Emails/desapprouver_agence.html.twig',
                    array('name' => $name)
                ),
                'text/html'
            )
        ;
        $this->get('mailer')->send($message);
        return $this->render('@App/Emails/approuver_agence.html.twig',array('name'=>$name));
    }

}
