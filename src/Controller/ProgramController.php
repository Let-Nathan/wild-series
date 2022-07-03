<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Program;
use App\Entity\User;
use App\Form\CommentType;
use App\Form\ProgramType;
use App\Repository\CommentRepository;
use App\Repository\ProgramRepository;
use App\Service\Slugify;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/program')]
class ProgramController extends AbstractController
{

    #[Route('/new', name: 'app_program_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProgramRepository $programRepository, Slugify $slugify, MailerInterface $mailer): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);


        if ($form->isSubmitted() ) {

            $program->setSlug($slugify->generate($program->getTitle()));
            $program->setOwner($this->getUser());
            $programRepository->add($program, true);
            $this->addFlash('success', 'Program have been successfully created');
            $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to('youremail@exemple.com')
                ->subject('Une nouvelle série vient d\'être publiée !')
                ->html('<p>Une nouvelle série vient d\'être publiée sur Wild Séries !</p>');

            $mailer->send($email);
            return $this->redirectToRoute('app_category_index', []);
        }

        return $this->renderForm('program/new.html.twig', [
            'program' => $program,
            'form' => $form,
        ]);
    }

    #[Route('/{category_id}', name: 'app_program_show', methods: ['GET', 'POST'])]
    #[Entity("category", options: ["id" => "category_id"])]
    public function show(Request $request, Category $category, CommentRepository $commentRepository, ProgramRepository $programRepository, RequestStack $requestStack): Response
    {
        // Get user sess
        $session = $requestStack->getSession();


        $comment = new Comment();

        $formCom = $this->createForm(CommentType::class, $comment);
        $formCom->handleRequest($request);

        $formSearch = $this->createForm(SearchType::class, null, [
            'method' => 'GET',
        ]);
        $formSearch->handleRequest($request);

        //Form Search render
        if ($formSearch->isSubmitted() && $formSearch->isValid()) {

            $search = $formSearch->getData();

            return $this->render('program/show.html.twig', [
                'program' => $programRepository->findLikeName($search),
                'formCom' => $formCom,
                'comments' => $commentRepository->findBy([], ['id' => 'DESC'], 4),
                'commentType' => $formCom->createView(),
                'category' => $category,
                'searchType' => $formSearch->createView(),
            ]);
        }

        //Comments form
        if ($formCom->isSubmitted() && $formCom->isValid()) {

            $comment->setUser($this->getUser());
            $commentRepository->add($comment, true);

            return $this->render('program/show.html.twig', [
            'formCom' => $formCom,
            'comments' => $commentRepository->findBy([], ['id' => 'DESC'], 4),
            'commentType' => $formCom->createView(),
            'category' => $category,
            'program' => $programRepository->findBy(['category' => $category->getId() ], ['title' => 'ASC']),
            'searchType' => $formSearch->createView(),
            ]);
        }

        return $this->render('program/show.html.twig', [
            'formCom' => $formCom,
            'comments' => $commentRepository->findBy([], ['id' => 'DESC'], 4),
            'commentType' => $formCom->createView(),
            'category' => $category,
            'program' => $programRepository->findBy(['category' => $category->getId() ], ['title' => 'ASC']),
            'searchType' => $formSearch->createView(),
        ]);
    }


    #[Route('/{slug}/edit', name: 'app_program_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Program $program, ProgramRepository $programRepository): Response
    {

        $form = $this->createForm(ProgramType::class, $program);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $programRepository->add($program, true);
            $this->addFlash('alert-success', 'Program have been successfully edited');
            return $this->redirectToRoute('app_program_show', [
                'category_id' => $program->getCategory()->getId(),
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('program/edit.html.twig', [
            'program' => $program,
            'form' => $form,
        ]);
    }

    #[Route('/deletePost/{id}/{comment}/{user}', name: ('deletePost'), methods: ['POST'])]
    #[Entity("comment", options: ['id' => 'comment'])]
    #[Entity("user", options: ['id' => 'user'])]
    public function deletePost(Category $category, Comment $comment, CommentRepository $commentRepository, User $user, Request $request): Response
    {

        if ($this->isCsrfTokenValid('delete'. $user->getId(), $request->request->get('_token'))) {
            $commentRepository->remove($comment, true);
        }
        $user->removeComment($comment);

        return $this->redirectToRoute('app_program_show', ['category_id' => $category->getId() ]);
    }

    #[Route('/delete/{id}', name: 'app_program_delete', methods: ['POST'])]
    public function delete(Program $program, Request $request, ProgramRepository $programRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $program->getId(), $request->request->get('_token'))) {
            $programRepository->remove($program, true);
            $this->addFlash('alert-danger', 'Program have been successfully delighted');
        }

        return $this->redirectToRoute('app_program_show', ['category_id' => $program->getCategory()->getId() ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/watchlist', name: 'app_program_watchlist')]
    public function addToWatchList(Program $program, EntityManagerInterface $emi, Category $category): Response
    {
        $user = $this->getUser();

        if($user->isInWatchList($program)) {
            $user->removeFromWatchList($program);
        } else {
            $this->getUser()->addToWatchList($program);
        }
        $emi->flush();

        return $this->json([
            'isInWatchList' => $user->isInWatchList($program),
        ]);
    }
}
