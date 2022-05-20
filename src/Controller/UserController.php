<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Services\CallUserApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @Route ("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route ("/add/{id}", requirements={"id" : "\w+"})
     *
     * @param Request     $request
     * @param CallUserAPI $api
     *
     * @return Response
     */
    public function addUser(Request $request, CallUserApi $api, string $id): Response
    {
        // création d'une nouvelle instance de User
        $user = new User();
        $userSession = $this->getUser();
        $user->setId($id);

        // récupération du formulaire
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $api->addUser($user);
            return $this->redirectToRoute("app_index_index");
        }

        return $this->render("user/form.html.twig", [
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route ("/edit/{id}",
     *     requirements={"id": "\d+"})
     *
     * @param Request     $request
     * @param CallUserApi $api
     * @param string         $id
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function editUser(Request $request, CallUserApi $api, string $id): Response
    {
        $user = $api->getUser($id);
        // TODO récupération de l'utilisateur via l'api
        // récupération du formulaire
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // TODO enregistrement de l'utilisateur via l'api + login
            $api->postUser($user);

            return $this->redirectToRoute("app_google_connect_google");
        }

        return $this->render("user/form.html.twig", [
            "form" => $form->createView(),
            "errors" => true,
        ]);
    }
}