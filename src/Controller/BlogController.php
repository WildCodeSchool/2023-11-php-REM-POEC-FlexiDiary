<?php

namespace App\Controller;

use App\Model\ArticleManager;
use App\Model\BlogsManager;
use DateTimeImmutable;

class BlogController extends AbstractController
{
    /**
     * Display List Blogs only 3 for the landing page
     */
    public function index(): string
    {
        $blogManager = new BlogsManager();
        $blogs = $blogManager->select3();
        return $this->twig->render('Blog/index.html.twig', [
            'blogs' => $blogs,
            'explore' => false,
        ]);
    }

    /**
     * Display List Blogs
     */
    public function explorer(): string
    {
        $blogManager = new BlogsManager();
        $blogs = $blogManager->selectAll();
        return $this->twig->render('Blog/index.html.twig', [
            'blogs' => $blogs,
            'explore' => true,
        ]);
    }

    /**
     * Show the blog
     */
    public function show(int $idBlog): string
    {
        $blogManager = new BlogsManager();
        $blog = $blogManager->selectOneBlogById((int)$idBlog);
        $articlesManager = new ArticleManager();
        $articles = $articlesManager->selectAllFromOne($blog['idBlog']);
        return $this->twig->render('Blog/show-blog.html.twig', [
            'blog' => $blog,
            'articles' => $articles,
        ]);
    }

    /**
     * Add a new Blog
     */
    public function add(): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $errors = [];
            $newBlog = array_map('trim', $_POST);
            if (strlen($newBlog['Title']) === 0  || strlen($newBlog['Title']) > 85) {
                $errors[] = 'Le titre du blog doit faire au minimum 2 caractères et maximum 85 caractères';
            }
            if (isset($newBlog['visibility'])) {
                $newBlog['visibility'] = true;
            } else {
                $newBlog['visibility'] = false;
            }
            if (empty($errors)) {
                $blogManager = new BlogsManager();
                $dateCreation = new DateTimeImmutable('now');
                $dateFormat = $dateCreation->format("Y-m-d");
                $idBlog = $blogManager->insert($newBlog, $dateFormat, 1);

                header('Location:/article/create?id=' . $idBlog);
                return null;
            }
        }
        return $this->twig->render('Blog/create-blog.html.twig');
    }


    /**
     * Delete a Blog
     */

    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = trim($_GET['id']);
            $blogManager = new BlogsManager();
            $blogManager->delete((int)$id);
            header('Location:/profil');
        }
    }
}
