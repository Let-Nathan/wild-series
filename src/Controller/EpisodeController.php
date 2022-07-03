<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


#[Route('/episode')]
class EpisodeController extends AbstractController
{
    #[Route('/{id}', name: 'app_episode_show', methods: ["GET"])]
    #[Entity("episode", options: ["id" => "id"])]
    public function show(Season $season): Response
    {

        return $this->render('episode/index.html.twig', [
            'episodes' => $season->getEpisodes(),
        ]);
    }

}