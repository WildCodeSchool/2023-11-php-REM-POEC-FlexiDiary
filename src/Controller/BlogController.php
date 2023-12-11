<?php

namespace App\Controller;

use App\Model\BlogsManager;

class BlogController extends AbstractController
{
    /**
     * Display List Blogs
     */
    public function index(): string
    {
        $blogManager = new BlogsManager();
        $blogs = $blogManager->selectAll();

        return $this->twig->render('Blog/index.html.twig', [
            'blogs' => $blogs]);
    }
}
