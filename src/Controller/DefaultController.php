<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController {


//    /**
//     * @Route ("/test")
//     */
    #[Route('/', name: 'app_index')]
    public function bbq(): Response
    {
        $var = "test";

       return $this->render('base.html.twig', ['var' => $var]);
    }
}