<?php

namespace AssociationBundle\Controller;

use AppBundle\Entity\User;
use AssociationBundle\Entity\Adherance;
use AssociationBundle\Entity\Association;
use AssociationBundle\Entity\Category;
use BackofficeBundle\Entity\Notification;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
/**
 * Dashboard controller.
 *
 * @Route("/dashboard")
 */
class DashboardController extends Controller
{

    



    /**
     * @Route("/manager/association", name="manager_association_show",methods={"GET"})
     */
    public function showAssociationToManagerAction(Request $request)
    {

        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array('username'=>$this->getUser()->getUsername()));
        $association = $this->getDoctrine()->getRepository('AssociationBundle:Association')->findOneBy(array('manager'=>$user));
        $editForm = $this->createForm('AssociationBundle\Form\AssociationType', $association);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('manager_association_edit', array('id' => $association->getId()));
        }
        return $this->render('@Association/dashboard/association/show.html.twig', array(
            'association' => $association,
            'edit_form' => $editForm->createView(),
        ));
    }

    // TO:DO : Rodha bil id mté3ou
    /**
     * @Route("/manager/association/{id}/edit", name="manager_association_edit",methods={"GET","POST"})
     */
    public function editAction(Request $request, Association $association)
    {
        $editForm = $this->createForm('AssociationBundle\Form\AssociationType', $association);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('manager_association_edit', array('id' => $association->getId()));
        }

        return $this->render('@Association/association/manager/edit.html.twig', array(
            'association' => $association,
            'edit_form' => $editForm->createView(),
        ));
    }













    /**
     * Lists all adherance entities.
     *
     * @Route("/manager/adherance", name="dashboard_manager_adherance_index",methods={"GET"})
     */
    public function indexAdheranceAction()
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array('username'=>$this->getUser()->getUsername()));
        $association = $this->getDoctrine()->getRepository('AssociationBundle:Association')->findOneBy(array('manager'=>$user));

        $em = $this->getDoctrine()->getManager();

        $adherances = $em->getRepository('AssociationBundle:Adherance')->findBy(array('association'=>$association));

        return $this->render('@Association/dashboard/adherance/index.html.twig', array(
            'adherances' => $adherances,
        ));
    }

    /**
     * Creates a new adherance entity.
     *
     * @Route("/manager/adherance/new", name="dashboard_manager_adherance_new",methods={"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $adherance = new Adherance();
        $form = $this->createForm('AssociationBundle\Form\AdheranceType', $adherance);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array('username'=>$this->getUser()->getUsername()));
            $association = $this->getDoctrine()->getRepository('AssociationBundle:Association')->findOneBy(array('manager'=>$user));
            $adherance->setAssociation($association);
            $em = $this->getDoctrine()->getManager();
            $user->addRole("ROLE_MEMBER");


            $em->persist($user);
            $em->persist($adherance);
            $em->flush();

            return $this->redirectToRoute('dashboard_manager_adherance_show', array('id' => $adherance->getId()));
        }


        $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        $adherances = $this->getDoctrine()->getRepository('AssociationBundle:Adherance')->findAll();
        $notusers = array();
        foreach ($adherances as $adherance){
            if(in_array($adherance->getUser(), $users, true)){
                $notusers[] = $adherance->getUser();
            }
        }
var_dump(sizeof($notusers));
        $form->add('user', EntityType::class, [
            'class' => 'AppBundle\Entity\User',
            'empty_data' => true,
            'choice_label' => 'username',
            'mapped' => false,
        ]);
           $form->get('user')->setData($notusers);

        return $this->render('@Association/dashboard/adherance/new.html.twig', array(
            'adherance' => $adherance,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a adherance entity.
     *
     * @Route("/manager/adherance/{id}", name="dashboard_manager_adherance_show",methods={"GET"})
     */
    public function showAdheranceAction(Adherance $adherance)
    {

        return $this->render('@Association/dashboard/adherance/show.html.twig', array(
            'adherance' => $adherance,
        ));
    }

    /**
     * Displays a form to edit an existing adherance entity.
     *
     * @Route("/manager/adherance/{id}/edit", name="dashboard_manager_adherance_edit",methods={"GET", "POST"})
     */
    public function editAdheranceAction(Request $request, Adherance $adherance)
    {
        $editForm = $this->createForm('AssociationBundle\Form\AdheranceType', $adherance);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dashboard_manager_adherance_edit', array('id' => $adherance->getId()));
        }

        return $this->render('@Association/dashboard/adherance/edit.html.twig', array(
            'adherance' => $adherance,
            'edit_form' => $editForm->createView(),
        ));
    }

    /* CATEGORY */
    /**
     * Displays a form to edit an existing category entity.
     *
     * @Route(path="/dashboard/admin/category/{id}/edit", name="admin_category_edit",methods={"GET","POST"})
     * @IsGranted("ROLE_SUPER_ADMIN")
     */
    public function editCategoryAdminAction(Request $request, Category $category)
    {
        $editForm = $this->createForm('AssociationBundle\Form\CategoryType', $category);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_category_edit', array('id' => $category->getId()));
        }

        return $this->render('@Association/dashboard/category/edit.html.twig', array(
            'category' => $category,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Creates a new category entity.
     *
     * @Route(path="/admin/category/new", name="category_new",methods={"GET", "POST"})
     */
    public function newCategoryAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm('AssociationBundle\Form\CategoryType', $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('category_show', array('id' => $category->getId()));
        }

        return $this->render('@Association/dashboard/category/new.html.twig', array(
            'category' => $category,
            'form' => $form->createView(),
        ));
    }
}
