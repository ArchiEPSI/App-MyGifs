<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends AbstractController
{
    /**
     * @Route ("/user/add")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function addUser(Request $request): Response
    {
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
     * @Route ("/user/edit/{id}",
     *     requirements={"id": "\d+"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function editUser(Request $request): Response
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