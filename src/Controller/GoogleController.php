<?php

declare(strict_types=1);

namespace App\Controller;


use App\Entity\User;
use App\Services\CallUserApi;
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
     * @param CallUserApi $api
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function connectCheckAction(CallUserApi $api)
    {
        $user = $api->getUser($this->getUser()->getUserIdentifier());
        if (! $user instanceof User) {
            return $this->redirectToRoute("app_user_adduser");
        }

        return $this->redirectToRoute("app_index_index");
    }
}