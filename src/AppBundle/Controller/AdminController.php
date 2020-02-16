<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{


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
