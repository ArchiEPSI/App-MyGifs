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
     * @Route ("/add")
     *
     * @param Request     $request
     * @param CallUserAPI $api
     *
     * @return Response
     */
    public function addUser(Request $request, CallUserApi $api): Response
    {
        $user = $api->getUser(1);
        $user->setFirstname("JBBBB");
        $api->postUser($user);
        // création d'une nouvelle instance de User
        $user = new User();
        // récupération du formulaire
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // TODO enregistrement de l'utilisateur via l'api + login
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
     * @param Request $request
     *
     * @return Response
     */
    public function editUser(Request $request, CallUserApi $userApi): Response
    {
        // création d'une nouvelle instance de User
        $user = new User();
        // TODO récupération de l'utilisateur via l'api
        // récupération du formulaire
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // TODO enregistrement de l'utilisateur via l'api + login
            return $this->redirectToRoute("app_index_index");
        }

        return $this->render("user/form.html.twig", [
            "form" => $form->createView(),
        ]);
    }
}