<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EnrollController extends AbstractController
{
    /**
     * @Route("/createEnroll", name="createEnroll")
     */
    public function createEnroll(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/EnrollController.php',
        ]);
    }
}
