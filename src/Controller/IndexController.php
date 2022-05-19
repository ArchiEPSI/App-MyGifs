<?php

declare(strict_types=1);

namespace App\Controller;

use App\Services\CallGifApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IndexController
 * @package App\Controller
 */
class IndexController extends AbstractController
{
    /**
     * @Route("/")
     *
     * @param  Request   $request
     * @param CallGifApi $api
     *
     * @return Response
     */
    public function index(Request $request, CallGifApi $api): Response
    {
        // récupération des gifs
        $gifs = $api->getGifs();

        return $this->render("home.html.twig", [
            "gifs" => $gifs,
        ]);
    }
}
