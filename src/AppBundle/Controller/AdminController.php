<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends Controller
{
    /**
     * @Route(path="/dashboard/association",name="association_manage")
     * @IsGranted("ROLE_ASSOCIATION_ADMIN")
     */
    public function manageAssociationAction(){
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array('username'=>$this->getUser()->getUsername()));
        $associations = $em->getRepository('AssociationBundle:Association')->findBy(array('manager'=>$user->getId()));

        return $this->render('@Association/association/index.html.twig', array(
            'associations' => $associations,
        ));
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
