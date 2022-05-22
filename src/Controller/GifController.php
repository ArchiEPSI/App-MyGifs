<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Gif;
use App\Form\GifType;
use App\Services\CallGifApi;
use App\Services\CallUserApi;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class GifController
 * @Route ("/gif")
 */
class GifController extends AbstractController
{
    /**
     * @Route("/add")
     *
     * @IsGranted("ROLE_USER")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function addGif(Request $request, CallUserApi $userApi, CallGifApi $gifApi): Response
    {
            $gif = new Gif();
            // récupération du formulaire
            $form = $this->createForm(GifType::class, $gif);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // récupération de l'utilisateur courant
                // enregistrement du Gif
                $gif->setOwner($this->getUser());
                try {
                    $gifApi->postGif($gif);
                }catch (\Exception $e) {
                    return $this->render("gif/form.html.twig", [
                        "form" => $form->createView(),
                        "errorMessage" => "Une erreur est survenue: Impossible d'enregistrer le gif"
                    ]);
                }
                return $this->redirectToRoute("app_index_index");
            }
            return $this->render("gif/form.html.twig", [
                "form" => $form->createView(),
            ]);
    }

    /**
     * @Route("/edit/{id}", requirements={"id": "\d+"})
     *
     * @IsGranted("ROLE_USER")
     *
     * @param Request $request
     *
     * @param CallUserApi $userApi
     * @param CallGifApi  $gifApi
     * @param int         $id
     *
     * @return Response
     */
    public function editGif(Request $request, CallUserApi $userApi, CallGifApi $gifApi, int $id): Response
    {
        if ($this->isGranted('ROLE_USER')) {
            $gif = new Gif();
            // récupération du formulaire
            $form = $this->createForm(GifType::class, $gif);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // récupération de l'utilisateur courant
                // enregistrement du Gif
                $gif->setOwner($this->getUser());
                try {
                    $gifApi->postGif($gif);
                }catch (\Exception $e) {
                    return $this->render("gif/form.html.twig", [
                        "form" => $form->createView(),
                        "errorMessage" => "Une erreur est survenue: Impossible d'enregistrer le gif"
                    ]);
                }
            }
            return $this->render("gif/form.html.twig", [
                "form" => $form->createView(),
            ]);
        };

        return $this->redirectToRoute("app_index_index");
    }

    /**
     * @Route("/delete/{id}", requirements={"id": "\d+"})
     *
     * @IsGranted("ROLE_USER")
     *
     * @param Request $request
     *
     * @param CallUserApi $userApi
     * @param CallGifApi  $gifApi
     * @param int         $id
     *
     * @return Response
     */
    public function deleteGif(Request $request, CallUserApi $userApi, CallGifApi $gifApi, int $id): Response
    {
        if ($this->isGranted('ROLE_USER')) {
            $gif = new Gif();
            // récupération du formulaire
            $form = $this->createForm(GifType::class, $gif);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // récupération de l'utilisateur courant
                // enregistrement du Gif
                $gif->setOwner($this->getUser());
                try {
                    $gifApi->postGif($gif);
                }catch (\Exception $e) {
                    return $this->render("gif/form.html.twig", [
                        "form" => $form->createView(),
                        "errorMessage" => "Une erreur est survenue: Impossible d'enregistrer le gif"
                    ]);
                }
            }
            return $this->render("gif/form.html.twig", [
                "form" => $form->createView(),
            ]);
        };

        return $this->redirectToRoute("app_index_index");
    }
}