<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BasketController
 */
class BasketController extends AbstractController
{
    /**
     * @return Response
     */
    public function createCommand(): Response
    {
        return new JsonResponse([]);
    }

    /**
     * @return Response
     */
    public function confirmCommand(): Response
    {
        return new JsonResponse([]);
    }

    /**
     * @return Response
     */
    public function cancelCommand(): Response
    {
        return new JsonResponse([]);
    }
}