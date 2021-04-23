<?php

namespace App\Controller;

use App\Entity\Activiteit;
use App\Entity\Soortactiviteit;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class BezoekerController extends AbstractController
{
    /**
     * @Route("/aanbodapi", name="aanbod")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Soortactiviteit::class);
        $soortactiviteiten = $repository->findAll();

        $repository = $this->getDoctrine()->getRepository(Activiteit::class);
        $huidigactiviteiten = $repository->findAll();

        return $this->json([$soortactiviteiten, $huidigactiviteiten]);
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function loginAction(AuthenticationUtils $authenticationUtils): Response
    {

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('bezoeker/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("registreren", name="registreren")
     */
    public function registreren(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->add('save', SubmitType::class, array('label' => "registreren"));
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // 2.5) Is the user new, gebruikersnaam moet uniek zijn
            $repository = $this->getDoctrine()->getRepository(User::class);
            $bestaande_user = $repository->findOneBy(['username' => $form->getData()->getUsername()]);

            if ($bestaande_user == null) {
                // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
                $user->setRoles(['ROLE_USER']);
                // 4) save the User!
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $this->addFlash(
                    'notice',
                    $user->getNaam() . ' is geregistreerd!'
                );

                return $this->redirectToRoute('homepage');
            } else {
                $this->addFlash(
                    'error',
                    $user->getUsername() . " bestaat al!"
                );
                return $this->render('bezoeker/registreren.html.twig', [
                    'form' => $form->createView()
                ]);
            }
        }

        return $this->render('bezoeker/registreren.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
