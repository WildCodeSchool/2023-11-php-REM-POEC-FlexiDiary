<?php

namespace App\Controller;

class BlogController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        return $this->twig->render('Blog/index.html.twig');
    }
}
