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
        return $this->redirectToRoute("app_command_removegif", ["id" => 1]);
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
     * @param SessionInterface $session
     * @param int              $id
     *
     * @return Response
     */
    public function removeGif(SessionInterface $session, int $id): Response
    {
        // récupération du panier en session
        $cart = $session->get("cart", []);
        // suppression de l'élément dans le panier
       $cart = array_filter($cart, function ($value) use ($id) {
            return $value != $id;
       });

        $session->set("cart", $cart);

        // si le panier n'est pas vide
        if (count($cart) > 0) {

            return new JsonResponse([
                "nb" => count($cart),
            ]);
        }
        $hml = $this->renderView('cart/empty.html.twig');

        return new JsonResponse([
            "html" => $hml,
            "nb" => count($cart),
        ]);
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