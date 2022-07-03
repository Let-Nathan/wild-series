<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Entity\Category;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\CategoryType;
use App\Form\ProgramType;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


#[Route('/actor', name: 'program_')]
class ActorController extends AbstractController
{

    #[Route('/{id}', name: 'actor', methods: ["GET"])]
    #[Entity("actor", options: ["id" => "id"])]
    public function showCategory(Program $program): Response
    {
    }

}