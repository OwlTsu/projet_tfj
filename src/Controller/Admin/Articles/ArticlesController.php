<?php

namespace App\Controller\Admin\Articles;

use App\Entity\Article;
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

    #[Route('/post/index', name: 'app_admin_post_index', methods: ['GET'])]
    public function index(): Response
    {
        $articles = $this->ArticleRepository->findAll();

        return $this->render('pages/admin/articles/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/articles/create', name: 'app_admin_articles_create', methods: ['GET', 'articles'])]
    public function create(Request $request): Response
    {
        if (0 == count($this->categoryRepository->findAll())) {
            $this->addFlash('warning', 'Pour créer un nouvel article, vous devez créer au moins une catégorie.');

            return $this->redirectToRoute('app_admin_category_index');
        }

        $article = new article();

        $form = $this->createForm(AdminArticlesFormType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var User
             */
            $user = $this->getUser();

            $article->setUser($user);
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

    #[Route('/articles/edit/{id<\d+>}', name: 'app_admin_articles_edit', methods: ['GET', 'article'])]
    public function edit(article $article, Request $request): Response
    {
        $form = $this->createForm(AdminArticlesFormType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var User
             */
            $user = $this->getUser();

            $article->setUser($user);
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

    #[Route('/articles/delete/{id<\d+>}', name: 'app_admin_articles_delete', methods: ['articles'])]
    public function delete(article $articles, Request $request): Response
    {
        if ($this->isCsrfTokenValid("delete-articles-{$articles->getId()}", $request->request->get('csrf_token'))) {
            $this->entityManager->remove($articles);
            $this->entityManager->flush();

            $this->addFlash('success', "L'article a été supprimé");
        }

        return $this->redirectToRoute('app_admin_articles_index');
    }
}
