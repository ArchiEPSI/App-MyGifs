<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Command;
use App\Services\Calculs;
use App\Services\CallCommandApi;
use App\Services\CallGifApi;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class cartController
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
        return $this->redirectToRoute("app_command_getcart");
    }

    /**
     * @Route ("/cart", methods={"GET"})
     *
     * @param SessionInterface $session
     * @param CallGifApi       $gifApi
     * @param CallCommandApi   $commandApi
     *
     * @return Response
     */
    public function getCart(SessionInterface $session, CallGifApi $gifApi, CallCommandApi $commandApi, Calculs $calculService): Response
    {
        // récupération du panier en session
        $cart = $session->get("cart", []);

        if (!count($cart) > 0) {
            $html = $this->renderView('cart/empty.html.twig');

            new JsonResponse([
                "html" => $html,
            ]);
        }

        // récupération des gifs
        $gifs = new ArrayCollection();
        foreach ($cart as $index => $id) {
            $gif = $gifApi->getGif($id);
            $gifs->add($gif);
        }

        // récupération du panier en base de données
        $command = $commandApi->getCart();
        if (!$command instanceof Command) {
            $command = new Command();
        }

        $command->setGifs($gifs);
        $command->setTtc($calculService->getTotal($gifs));
        // calcul du total
        $html = $this->renderView('cart/list.html.twig', [
            "command" => $command,
        ]);

        return new JsonResponse([
            "html" => $html,
        ]);
    }

    /**
     * @Route (
     *     "/add/{idGif}",
     *     requirements={"idGif" : "\d+"},
     *     methods={"POST"}
     *     )
     *
     * @param SessionInterface $session
     * @param int              $idGif
     *
     * @return Response
     */
    public function addGif(SessionInterface $session, int $idGif): Response
    {
        // récupération du panier en session
        $cart = $session->get("cart", []);
        if (in_array($idGif, $cart, true)) {

            return new JsonResponse([]);
        }
        // sinon ajoute l'id du gif au panier en session
        $cart[] = $idGif;
        $session->set("cart", $cart);

        return new JsonResponse([
            "nb" => count($cart),
        ]);
    }

    /**
     * @Route ("/remove/{id}", requirements={"id" : "\d+"})
     *
     * @param Request $request
     * @param SessionInterface $session
     * @param int $idGif
     *
     * @return Response
     */
    public function removeGif(Request $request, SessionInterface $session, int $idGif): Response
    {
        // récupération du panier en session
        $cart = $session->get("cart", []);
        // suppression de l'élément dans le panier
        $key = array_search($idGif, $cart);
        unset($cart, $key);

        $session->set("cart", $cart);

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