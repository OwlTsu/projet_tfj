<?php

namespace App\Controller\Admin\Home;

use App\Repository\TagRepository;
use App\Repository\LikeRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Repository\CommentRepository;
use App\Repository\ContactRepository;
use App\Repository\ArticlesRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
final class HomeController extends AbstractController
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private ArticlesRepository $articlesRepository,
        // private TagRepository $tagRepository,
        // private CommentRepository $commentRepository,
        // private UserRepository $userRepository,
        private ContactRepository $contactRepository,
        // private LikeRepository $likeRepository,
    ) {}

    #[Route('/home', name: 'app_admin_home', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('pages/admin/home/index.html.twig', [
            'category_count' => $this->categoryRepository->count(),
            'articles_count' => $this->articlesRepository->count(),
            // 'tags_count' => $this->tagRepository->count(),
            // 'comments_count' => $this->commentRepository->count(),
            // 'users_count' => $this->userRepository->count(),
            'contacts_count' => $this->contactRepository->count(),
            // 'likes_count' => $this->likeRepository->count(),
        ]);
    }
}
