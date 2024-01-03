<?php

namespace App\Controller;

use App\Model\BlogsManager;

class HomeController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        $blogManager = new BlogsManager();
        $blogs = $blogManager->select3();


        return $this->twig->render('Home/index.html.twig', [
            "blogs" => $blogs
        ]);
    }
    /**
     * Display privacy policy page
     */
    public function privacypolicy(): string
    {
        return $this->twig->render('Home/privacypolicy.html.twig');
    }

    public function login(): string
    {
        return $this->twig->render('Home/login.html.twig');
    }
}
