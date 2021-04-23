<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class BaseController extends AbstractController
{
    public function index()
    {   
        return $this->render('app.html.twig', [
        ]);
    }

    /**
     * @Route("/api/user", name="user")
     */
    public function apiuser()
    {
        return $this->json($this->getUser());
    }
}
