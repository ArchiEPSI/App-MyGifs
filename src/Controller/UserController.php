<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Services\CallUserApi;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
     * @Route (
     *     "/edit/{id}",
     *     requirements={"id": "\d+"}
     *     )
     *
     * @IsGranted("ROLE_USER")
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
        // récupération du formulaire
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $api->editUser($user);
            return $this->redirectToRoute("app_google_connect_google");
        }

        return $this->render("user/form.html.twig", [
            "form" => $form->createView(),
            "errors" => true,
        ]);
    }

    /**
     * @Route (
     *     "/detail/{id}",
     *     requirements={"id": "\d+"}
     *     )
     *
     * @IsGranted("ROLE_USER")
     *
     * @param Request     $request
     * @param CallUserApi $api
     * @param string         $id
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function detailUser(Request $request, CallUserApi $api, string $id): Response
    {
        $user = $api->getUser($id);

        return $this->render("user/detail.html.twig", [
            "user" => $user,
        ]);
    }
}