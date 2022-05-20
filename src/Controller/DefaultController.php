<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController {

    //Some routes test
//    /**
//     * @Route ("/test")
//     */
//    #[Route('/bbq')]

    public function bbq(): Response
    {
        $var = "test";

       return $this->render('base.html.twig', ['var' => $var]);
    }
}