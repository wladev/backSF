<?php

// src/Controller/RestrictedController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class RestrictedController extends AbstractController
{
    public function restrictedAction(): Response
    {
        // Code pour gérer la réponse appropriée, par exemple une erreur 403 Forbidden.
        return new Response("Accès interdit.", 403);
    }
}
