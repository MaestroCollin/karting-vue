<?php

namespace App\Controller;

use App\Entity\Activiteit;
use App\Form\ChangePasswordType;
use App\Form\UserPorfileType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DeelnemerController extends AbstractController
{
    /**
     * @Route("/api/deelnemer", name="deelnemer")
     */
    public function index(): Response
    {
        $usr = $this->get('security.token_storage')->getToken()->getUser();

        $beschikbareActiviteiten = $this->getDoctrine()
            ->getRepository('App:Activiteit')
            ->getBeschikbareActiviteiten($usr->getId());

        $ingeschrevenActiviteiten = $this->getDoctrine()
            ->getRepository('App:Activiteit')
            ->getIngeschrevenActiviteiten($usr->getId());

        $totaal = $this->getDoctrine()
            ->getRepository('App:Activiteit')
            ->getTotaal($ingeschrevenActiviteiten);

            return $this->json([$beschikbareActiviteiten, $ingeschrevenActiviteiten, $totaal]);
    }

    /**
     * @Route("/api/user/inschrijven/{id}", name="inschrijven")
     */
    public function inschrijvenActiviteitAction($id)
    {

        $activiteit = $this->getDoctrine()
            ->getRepository(Activiteit::class)
            ->find($id);
        if ($activiteit->getDatum() >= date_format(new DateTime(), 'd-m-Y')) {
            $usr = $this->get('security.token_storage')->getToken()->getUser();
            $usr->addActiviteit($activiteit);

            $em = $this->getDoctrine()->getManager();
            $em->persist($usr);
            $em->flush();

            return $this->json(1);
        } else {
            return $this->json(1);
        }
    }


    /**
     * @Route("/api/user/uitschrijven/{id}", name="uitschrijven")
     */
    public function uitschrijvenActiviteitAction($id)
    {
        $activiteit = $this->getDoctrine()
            ->getRepository('App:Activiteit')
            ->find($id);
        $usr = $this->get('security.token_storage')->getToken()->getUser();
        $usr->removeActiviteit($activiteit);
        $em = $this->getDoctrine()->getManager();
        $em->persist($usr);
        $em->flush();
        return $this->json(1);
    }

    /**
     * @Route("/api/user/activiteiten", name="apiactiviteitenuser")
     */
    public function profile()
    {
        $usr = $this->get('security.token_storage')->getToken()->getUser();
        $ingeschrevenActiviteiten = $this->getDoctrine()
            ->getRepository('App:Activiteit')
            ->getIngeschrevenActiviteiten($usr->getId());

       return $this->json($ingeschrevenActiviteiten);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/api/user/profile/change", name="profilechangeapi", methods="POST")
     */
    public function profileChange(Request $request)
    {
        $user = $this->getUser();

        $form = $this->createForm(UserPorfileType::class, $user);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->json(204);


    }

    /**
     * @Route("/user/profile/password/change", name="change_user_password")
     */
    public function change_user_password(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $form = $this->createForm(ChangePasswordType::class);
        $form->add('save', SubmitType::class, array('label' => "Wijzigen"));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $old_pwd = $request->get('change_password')["old_password"];
            $new_pwd = $request->get('change_password')["new_password"]["first"];
            $new_pwd_confirm = $request->get('change_password')["new_password"]["second"];
            $user = $this->getUser();
            $checkPass = $passwordEncoder->isPasswordValid($user, $old_pwd);

            if ($checkPass === true) {
                if ($new_pwd === $new_pwd_confirm) {
                    $password = $passwordEncoder->encodePassword($user, $new_pwd);

                    $em = $this->getDoctrine()->getManager();
                    $user->setPassword($password);
                    $em->persist($user);
                    $em->flush();
                }
                return $this->redirect('/user/profile');
            } else {
                $this->addFlash(
                    'error',
                    'Wachtwoord onjuist!'
                );
                return $this->redirect('/user/profile/password/change');
            }
        } else {
            return $this->render('deelnemer/passwordChange.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }

}
