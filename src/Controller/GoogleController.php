<?php

declare(strict_types=1);

namespace App\Controller;


use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GoogleController
 */
class GoogleController extends AbstractController
{
    /**
     * @Route("/connect/google", name="connect_google")
     *
     * @param ClientRegistry $clientRegistry
     *
     * @return mixed
     */
    public function connectAction(ClientRegistry $clientRegistry)
    {
        //Redirect to google
        return $clientRegistry->getClient('google')->redirect([], []);
    }

    /**
     * @Route("/connect/google/check", name="connect_google_check")
     *
     * @param Request $request
     */
    public function connectCheckAction(Request $request)
    {
       $this->render("views/home.html.twig");
    }

}