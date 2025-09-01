<?php

namespace App\Controller\Admin\Articles;

use App\Entity\Articles;
use App\Entity\User;
use App\Form\AdminArticlesFormType;
use App\Repository\CategoryRepository;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
final class ArticlesController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ArticlesRepository $ArticleRepository,
        private CategoryRepository $categoryRepository,
    ) {}

    #[Route('/articles/index', name: 'app_admin_articles_index', methods: ['GET'])]
    public function index(): Response
    {
        $articles = $this->ArticleRepository->findAll();
        $articlesCount = count($articles);

        return $this->render('pages/admin/articles/index.html.twig', [
            'articles' => $articles,
            'articles_count' => $articlesCount,
        ]);
    }

    #[Route('/articles/create', name: 'app_admin_articles_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        if (0 == count($this->categoryRepository->findAll())) {
            $this->addFlash('warning', 'Pour créer un nouvel article, vous devez créer au moins une catégorie.');

            return $this->redirectToRoute('app_admin_category_index');
        }

        $article = new Articles();

        $form = $this->createForm(AdminArticlesFormType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setCreatedAt(new \DateTimeImmutable());
            $article->setUpdatedAt(new \DateTimeImmutable());

            $this->entityManager->persist($article);
            $this->entityManager->flush();

            $this->addFlash('success', "L'article a été créé et sauvegardé.");

            return $this->redirectToRoute('app_admin_articles_index');
        }

        return $this->render('pages/admin/articles/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/articles/show/{id<\d+>}', name: 'app_admin_articles_show', methods: ['GET'])]
    public function show(Articles $article): Response
    {
        return $this->render('pages/admin/articles/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/articles/edit/{id<\d+>}', name: 'app_admin_articles_edit', methods: ['GET', 'POST'])]
    public function edit(Articles $article, Request $request): Response
    {
        $form = $this->createForm(AdminArticlesFormType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setUpdatedAt(new \DateTimeImmutable());

            $this->entityManager->persist($article);
            $this->entityManager->flush();

            $this->addFlash('success', "L'article a été modifié et sauvegardé.");

            return $this->redirectToRoute('app_admin_articles_index');
        }

        return $this->render('pages/admin/articles/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/articles/delete/{id<\d+>}', name: 'app_admin_articles_delete', methods: ['POST'])]
    public function delete(Articles $article, Request $request): Response
    {
        if ($this->isCsrfTokenValid("delete-article-{$article->getId()}", $request->request->get('csrf_token'))) {
            $this->entityManager->remove($article);
            $this->entityManager->flush();

            $this->addFlash('success', "L'article a été supprimé");
        }

        return $this->redirectToRoute('app_admin_articles_index');
    }
}
