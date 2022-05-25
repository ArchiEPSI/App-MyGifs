<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Command;
use App\Services\CallCommandApi;
use App\Services\CallGifApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BasketController
 * @Route ("/command")
 */
class CommandController extends AbstractController
{
    /**
     * @Route("/valid")
     */
    public function valid(): Response
    {
        // récupération du panier et de l'utilisateur

        // calculs
        return $this->render("command/detail.html.twig");
    }

    /**
     * @Route ("/command/create")
     * @return Response
     */
    public function create(): Response
    {
        return new JsonResponse([]);
    }

    /**
     * @Route ("/add/{idGif}", requirements={"idGif" : "\d+"}, methods={"POST"})
     *
     * @return Response
     */
    public function addGif(Request $request, CallGifApi $gifApi, CallCommandApi $commandApi, int $idGif): Response
    {
        // récupération du gif et de la commande
        //$gif = $gifApi->getGif($idGif);
        $command = $commandApi->getBasket();
        if (!$command instanceof Command) {
            $command = new Command();
        }

        $html = $this->renderView('basket/_list.html.twig', [
            "command" => $command,
        ]);

        return new JsonResponse([
            "html" => $html,
        ]);
    }

    /**
     * @Route ("/remove")
     * @return Response
     */
    public function remove(): Response
    {
        return new JsonResponse([]);
    }

    /**
     * @return Response
     */
    public function confirm(): Response
    {
        return new JsonResponse([]);
    }

    /**
     * @return Response
     */
    public function cancel(): Response
    {
        return new JsonResponse([]);
    }
}