<?php

namespace App\Controller;

class HomeController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        return $this->twig->render('Home/index.html.twig');
    }
    /**
     * Display privacy policy page
     */
    public function privacypolicy(): string
    {
        return $this->twig->render('Home/privacypolicy.html.twig');
    }
}
