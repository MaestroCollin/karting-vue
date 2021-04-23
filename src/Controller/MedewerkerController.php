<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Activiteit;
use App\Entity\Soortactiviteit;
use App\Entity\User;
use App\Form\ActiviteitType;
use App\Form\SoortActiviteitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class MedewerkerController extends AbstractController
{
    /**
     * @Route("/admin/activiteiten", name="activiteitenoverzicht")
     */
    public function activiteitenOverzichtAction()
    {

        $activiteiten = $this->getDoctrine()
            ->getRepository('App:Activiteit')
            ->findAll();

        return $this->render('medewerker/activiteiten.html.twig', [
            'activiteiten' => $activiteiten
        ]);
    }

    /**
     * @Route("/admin/details/{id}", name="details")
     */
    public function detailsAction($id)
    {
        $activiteiten = $this->getDoctrine()
            ->getRepository('App:Activiteit')
            ->findAll();
        $activiteit = $this->getDoctrine()
            ->getRepository('App:Activiteit')
            ->find($id);

        $deelnemers = $this->getDoctrine()
            ->getRepository('App:User')
            ->getDeelnemers($id);


        return $this->render('medewerker/details.html.twig', [
            'activiteit' => $activiteit,
            'deelnemers' => $deelnemers,
            'aantal' => count($activiteiten)
        ]);
    }

    /**
     * @Route("/admin/beheer", name="beheer")
     */
    public function beheerAction()
    {
        $activiteiten = $this->getDoctrine()
            ->getRepository('App:Activiteit')
            ->findAll();

        return $this->render('medewerker/beheer.html.twig', [
            'activiteiten' => $activiteiten
        ]);
    }

    /**
     * @Route("/admin/add", name="add")
     */
    public function addAction(Request $request)
    {
        // create a user and a contact
        $a = new Activiteit();

        $form = $this->createForm(ActiviteitType::class, $a);
        $form->add('save', SubmitType::class, array('label' => "voeg toe"));
        //$form->add('reset', ResetType::class, array('label'=>"reset"));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($a);
            $em->flush();

            $this->addFlash(
                'notice',
                'activiteit toegevoegd!'
            );
            return $this->redirectToRoute('beheer');
        }
        $activiteiten = $this->getDoctrine()
            ->getRepository('App:Activiteit')
            ->findAll();
        return $this->render('medewerker/add.html.twig', array(
            'form' => $form->createView(), 'naam' => 'toevoegen', 'aantal' => count($activiteiten)
        ));
    }

    /**
     * @Route("/admin/update/{id}", name="update")
     */
    public function updateAction($id, Request $request)
    {
        $a = $this->getDoctrine()
            ->getRepository('App:Activiteit')
            ->find($id);

        $form = $this->createForm(ActiviteitType::class, $a);
        $form->add('save', SubmitType::class, array('label' => "aanpassen"));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            // tells Doctrine you want to (eventually) save the contact (no queries yet)
            $em->persist($a);


            // actually executes the queries (i.e. the INSERT query)
            $em->flush();
            $this->addFlash(
                'notice',
                'activiteit aangepast!'
            );
            return $this->redirectToRoute('beheer');
        }

        $activiteiten = $this->getDoctrine()
            ->getRepository('App:Activiteit')
            ->findAll();

        return $this->render('medewerker/add.html.twig', array('form' => $form->createView(), 'naam' => 'aanpassen', 'aantal' => count($activiteiten)));
    }

    /**
     * @Route("/admin/delete/{id}", name="delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $a = $this->getDoctrine()
            ->getRepository('App:Activiteit')->find($id);
        $em->remove($a);
        $em->flush();

        $this->addFlash(
            'notice',
            'activiteit verwijderd!'
        );
        return $this->redirectToRoute('beheer');
    }

    /**
     * @Route("/admin/activiteiten/index", name="activiteitenbeheer")
     */
    public function activiteitenBeheer()
    {
        $activiteiten = $this->getDoctrine()->getRepository(Soortactiviteit::class)->findAll();

        return $this->render('medewerker/activiteiten/index.html.twig', [
            'activiteiten' => $activiteiten,
        ]);
    }

    /**
     * @Route("/admin/activiteiten/add", name="addActiviteit")
     */
    public function addActiviteit(Request $request)
    {
        // create a user and a contact
        $a = new Soortactiviteit();

        $form = $this->createForm(SoortActiviteitType::class, $a);
        $form->add('save', SubmitType::class, array('label' => "voeg toe"));
        //$form->add('reset', ResetType::class, array('label'=>"reset"));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($a);
            $em->flush();

            $this->addFlash(
                'notice',
                'soort activiteit toegevoegd!'
            );
            return $this->redirectToRoute('activiteitenbeheer');
        }
        $activiteiten = $this->getDoctrine()
            ->getRepository('App:Activiteit')
            ->findAll();
        return $this->render('medewerker/activiteiten/add.html.twig', array(
            'form' => $form->createView(), 'naam' => 'toevoegen', 'aantal' => count($activiteiten)
        ));
    }

    /**
     * @Route("/admin/activiteit/update/{id}", name="updateSoortActiviteit")
     */
    public function updateSoortActiviteit($id, Request $request)
    {
        $a = $this->getDoctrine()
            ->getRepository('App:Soortactiviteit')
            ->find($id);

        $form = $this->createForm(SoortActiviteitType::class, $a);
        $form->add('save', SubmitType::class, array('label' => "Aanpassen"));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            // tells Doctrine you want to (eventually) save the contact (no queries yet)
            $em->persist($a);


            // actually executes the queries (i.e. the INSERT query)
            $em->flush();
            $this->addFlash(
                'notice',
                'Soort activiteit aangepast!'
            );
            return $this->redirectToRoute('activiteitenbeheer');
        }

        $activiteiten = $this->getDoctrine()
            ->getRepository('App:Activiteit')
            ->findAll();

        return $this->render('medewerker/activiteiten/add.html.twig', array('form' => $form->createView(), 'naam' => 'aanpassen', 'aantal' => count($activiteiten)));
    }

    /**
     * @Route("/admin/user/index", name="userbeheer")
     */
    public function userBeheer()
    {
        $users =
            $this->getDoctrine()
            ->getRepository(User::class)
            ->findByRole('ROLE_USER');
           

        return $this->render('medewerker/users/index.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/admin/user/{id}/delete", name="userDelete")
     */
    public function userDelete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $a = $this->getDoctrine()
            ->getRepository(User::class)->find($id);
        $em->remove($a);
        $em->flush();

        $this->addFlash(
            'notice',
            'User verwijderd!'
        );
        return $this->redirectToRoute('userbeheer');
    }
    /**
     * @Route("/admin/user/{user}/reset", name="userPasswordReset")
     */
    public function userPasswordReset(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $user->setPassword('$2y$13$Weh0hdyw8Z7ht3EF4FAHC.ctNgG8t0e8ZF8tVN.zG32qDSltZCjUK');
        $em->flush();

        $this->addFlash(
            'notice',
            'Wachtwoord gereset!'
        );
        return $this->redirectToRoute('userbeheer');
    }
}
