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
        // récupération du formulaire
        $form = $this->createForm(GifType::class, new Gif());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // enregistrement du Gif

        }
        return $this->render("gif/form.html.twig", [
            "form" => $form->createView(),
        ]);
    }
}