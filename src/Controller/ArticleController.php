<?php

namespace App\Controller;

use App\Model\TagManager;
use DateTimeImmutable;
use DateTimeZone;

class ArticleController extends AbstractController
{
    public function create(string $id): ?string
    {
        /*Création d'un article
            -Formulaire à remplir
                -Titre
                -Contenu
                -Image
                -Catégorie / Tag
                -Date (?)
                -Visibilité
            -Utilisateur
            -Id du Blog
            */
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Filtrer le formulaire
            // $timeZone = new DateTimeZone('Europe/Paris');
            // $date = new DateTimeImmutable('now', $timeZone);
            /*Image :
            $_FILES[]
            ->move
            ->récupère le chemin du fichier
            ->BDD
            ->On fait quoi ? =>Redirection ?  Affichage de l'article ?
            */
        }
        $tagsManager = new TagManager();
        $tags = $tagsManager->selectAll();
        return $this->twig->render('Article/create.html.twig', [
            'tags' => $tags,
            'idBlog' => $id
        ]);
    }
}
