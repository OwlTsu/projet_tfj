<?php

namespace App\Controller\Visitor\Location;

use App\Entity\Articles;
use App\Entity\Category;
use App\Entity\SubCategory;
use App\Repository\ArticlesRepository;
use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LocationController extends AbstractController
{
    public function __construct(
        private ArticlesRepository $articlesRepository,
        private CategoryRepository $categoryRepository,
        private SubCategoryRepository $subCategoryRepository,
        private PaginatorInterface $paginator
    ) {}

    #[Route('/location', name: 'app_visitor_location', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $categories = $this->categoryRepository->findAll();
        $subCategories = $this->subCategoryRepository->findAll();
        $query = $this->articlesRepository->findAll(); // récupère tous les articles en location

        $articles = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            6 // nombre d'articles par page
        );

        return $this->render('pages/visitor/location/index.html.twig', [
            'categories' => $categories,
            'subCategories' => $subCategories,
            'articles' => $articles,
        ]);
    }

    #[Route('/location/categorie/{id<\d+>}', name: 'app_visitor_articles_filter_by_category', methods: ['GET', 'POST'])]
    public function filterByCategory(Category $category, Request $request): Response
    {
        $articles = $this->articlesRepository->findBy(['category' => $category]);

        $queryBuilder = $this->articlesRepository->createQueryBuilder('a')
            ->where('a.category = :category')
            ->setParameter('category', $category)
            ->orderBy('a.createdAt', 'DESC');

        $articles = $this->paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('pages/visitor/location/index.html.twig', [
            'categories' => $this->categoryRepository->findAll(),
            'subCategories' => $this->subCategoryRepository->findAll(),
            'articles' => $articles,
        ]);
    }

    // #[Route('/location/tag/{id<\d+>}', name: 'app_visitor_articles_filter_by_tag', methods: ['GET', 'POST'])]
    // public function filterByTag($id): Response
    // {
    //     // Suppose que tu as une méthode dans ton repository Articles pour filtrer par tag
    //     $articles = $this->articlesRepository->filterArticlesByTag($id);

    //     return $this->render('pages/visitor/location/index.html.twig', [
    //         'categories' => $this->categoryRepository->findAll(),
    //         // 'subCategories' => $this->subCategoryRepository ->findAll(),
    //         'articles' => $articles,
    //     ]);
    // }

    #[Route('/location/{id}', name: 'app_visitor_location_show', methods: ['GET'])]
    public function showArticle(Articles $article): Response
    {
        return $this->render('pages/visitor/location/show.html.twig', [
            'article' => $article,
        ]);
    }
}
