<?php

namespace App\Controller;

use App\Model\ArticleManager;
use App\Model\TagManager;
use DateTimeImmutable;

class ArticleController extends AbstractController
{
    public function create(int $idBlog): ?string
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $uploadDir = 'upload/';
            $baseDir = (dirname((dirname(__DIR__)))) . '/public/';
            if (!is_dir($baseDir . '/upload')) {
                mkdir($baseDir . '/upload', 0777);
            }
            $extension = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
            $uploadFile = $uploadDir . uniqid() . '.' . $extension;
            $authorizedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            $newArticle = array_map('trim', $_POST);


            if (isset($newArticle['visibility'])) {
                $newArticle['visibility'] = true;
            } else {
                $newArticle['visibility'] = false;
            }
            $errors = $this->validate($newArticle, $extension, $authorizedExtensions);
            if (!move_uploaded_file($_FILES['picture']['tmp_name'], $baseDir . $uploadFile)) {
                $errors[] = $baseDir . $uploadFile;
            }
            $dataArticleSecure = [];
            $dataArticleSecure['Title'] = htmlentities($newArticle['Title']);
            $dataArticleSecure['Content'] = htmlentities($newArticle['Content']);
            $dataArticleSecure['visibility'] = $newArticle['visibility'];
            $dataArticleSecure['tags'] = $newArticle['tags'];
            if (empty($errors)) {
                $imageArticle = $uploadFile;
                $dateCreation = new DateTimeImmutable('now');
                $dateFormat = $dateCreation->format("Y-m-d");
                $article = new ArticleManager();
                $article->insert($dataArticleSecure, $dateFormat, $imageArticle, $idBlog);
                header('Location: /blog/show?idBlog=' . $idBlog);
                return null;
            }
        }
        $tagsManager = new TagManager();
        $tags = $tagsManager->selectAll();
        return $this->twig->render('Article/create.html.twig', [
            'errors' => $errors,
            'tags' => $tags,
            'idBlog' => $idBlog
        ]);
    }


    private function validate(array $newArticle, string $extension, array $authorizedExtensions)
    {
        $maxFileSize = 1000000;
        $errors = [];
        if ($_FILES['picture']['error'] !== 0) {
            $errors[] = "Erreur de transfert de fichier. L'article n'a pas été ajouté.";
        }
        if (strlen($newArticle['Title']) === 0  || strlen($newArticle['Title']) > 255) {
            $errors[] = "Le titre de l'article doit faire au minimum 2 caractères et maximum 255 caractères";
        }
        if (strlen($newArticle['Content']) === 0) {
            $errors[] = "le contenu de l'article ne peut pas être vide.";
        }
        if (!in_array($extension, $authorizedExtensions)) {
            $errors[] = 'Selectionnez une image de type JPG, JPEG, PNG, OU WEBP.';
        }
        if (
            file_exists($_FILES['picture']['tmp_name']) &&
            filesize($_FILES['picture']['tmp_name']) > $maxFileSize
        ) {
            $errors[] = "Votre image est trop lourde 1Mo max.";
        }
        if (!isset($newArticle['tags'])) {
            $errors[] = " Tu dois ranger ton article dans une catégorie !";
        }
        return $errors;
    }
}
