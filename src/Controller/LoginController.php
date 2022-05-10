<?php

declare(strict_types=1);

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    /**
     * @Route("/logout")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function logout(Request $request): Response
    {
        return $this->render("home.html.twig");
    }
}