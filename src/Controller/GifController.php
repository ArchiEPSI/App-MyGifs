<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Gif;
use App\Form\GifType;
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
     * @param Request $request
     *
     * @return Response
     */
    public function addGif(Request $request): Response
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $gif = new Gif();
            // récupération du formulaire
            $form = $this->createForm(GifType::class, $gif);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // enregistrement du Gif
                $gif->setOwner($this->getUser());

            }
            return $this->render("gif/form.html.twig", [
                "form" => $form->createView(),
            ]);
        };

        return $this->redirectToRoute("app_login_login");
    }
}