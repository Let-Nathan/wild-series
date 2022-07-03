<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\CategoryType;
use App\Form\ProgramType;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use App\Service\Slugify;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


#[Route('/old', name: 'program_')]
class DefaultController extends AbstractController {

    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        /**
         * @Redirection after Get
         */
        if(isset($_GET['category'])) {
            $id = intval($_GET['category']);

            return $this->redirectToRoute('program_category', ['category_id' => $id]);
        }

        return $this->render('index.html.twig', ['categories' => $categories]);
    }

    #[Route('/category/new', name: 'createCategory')]
    public function newCategory(Request $request, CategoryRepository $categoryRepository): Response
    {

        $category = new Category();
        // Create the form, linked with $category
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Deal with the submitted data
            // For example : persiste & flush the entity
            // And redirect to a route that display the result
            $categoryRepository->add($category, true);
            return $this->redirectToRoute('program_index');
        }


        // Render the form (best practice)
        return $this->renderForm('category/new.html.twig', [
            'form' => $form,
        ]);
    }



    #[Route('/category/{category_id}', name: 'category',  methods: ["GET"])]
    #[Entity("category", options: ["id" => "category_id"])]
    public function showCategory(Category $category): Response
    {
          $programs = $category->getPrograms();

            if(isset($_GET['season'])) {
                $seasonId = intval($_GET['season']);
                return $this->redirectToRoute('program_episode_show', [
                    'category_id' => $category->getId(),
                    'season_id' => $seasonId,
                ]);
            }

        return $this->render('category.html.twig', [
            'programs' => $programs,
            'category' => $category,
        ]);
    }

    #[Route('/category/{category_id}/season/new', name: 'createProgram')]
    public function createProgram(Request $request, ProgramRepository $programRepository, Slugify $slugify): Response
    {
        $program = new Program();

        // Create the form, linked with $category
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Deal with the submitted data
            // For example : persiste & flush the entity
            // And redirect to a route that display the result
            $program->setSlug($slugify->generate($program->getTitle()));
            $programRepository->add($program, true);
            return $this->redirectToRoute('program_index');
        }

        return $this->renderForm('category/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @TODO MAKE NEW EPISODES CONTROLLER
     */
    #[Route('/category/{category_id}/season/{season_id}', name: 'episode_show', methods: ["GET"])]
    #[Entity("category", options: ["id" => "category_id"])]
    #[Entity("season", options: ["id" => "season_id"])]
    public function showSeason(Category $category, Season $season, Program $program): Response
    {
        return $this->render('season.html.twig', [
            'episodes' => $season->getEpisodes(),
            'season' => $season,
            'program' => $program

        ]);
    }

}