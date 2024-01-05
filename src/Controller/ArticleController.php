<?php

namespace App\Controller;

use App\Model\ArticleManager;
use App\Model\TagManager;
use DateTimeImmutable;

class ArticleController extends AbstractController
{
    public function create(string $idBlog): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];
            $newArticle = array_map('trim', $_POST);
            if (strlen($newArticle['Title']) === 0  || strlen($newArticle['Title']) > 255) {
                $errors[] = "Le titre de l'article doit faire au minimum 2 caractères et maximum 255 caractères";
            }
            if (strlen($newArticle['Content']) === 0) {
                $errors[] = "le contenu de l'article ne peut pas être vide.";
            }
            if (!isset($newArticle['idBlog'])) {
                $errors[] = "l'id du blog est manquant";
            }
            if (isset($newArticle['visibility'])) {
                $newArticle['visibility'] = true;
            } else {
                $newArticle['visibility'] = false;
            }
            if (!isset($newArticle['tags'])) {
                $errors[] = " Tu dois ranger ton article dans une catégorie !";
            }
            if (empty($errors)) {
                $dateCreation = new DateTimeImmutable('now');
                $dateFormat = $dateCreation->format("Y-m-d");
                $article = new ArticleManager();
                $article->insert($newArticle, $dateFormat);
                header('Location:/blog/show?idBlog=' . $idBlog);
                return null;
            }
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
            'idBlog' => $idBlog
        ]);
    }
}
