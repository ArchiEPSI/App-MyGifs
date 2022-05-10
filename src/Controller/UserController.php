<?php

declare(strict_types=1);

namespace App\Controller;

use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends AbstractController
{
    public function newUser(Request $request): Response
    {
        return $this->render("views/user/create.html.twig");
    }
}