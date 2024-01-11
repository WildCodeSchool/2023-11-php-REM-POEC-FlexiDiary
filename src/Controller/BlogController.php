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
            'owner' => false,
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
            'owner' => false,
        ]);
    }

    /**
     * Display List Blogs by User Connected
     */
    public function blogsOfUser($idUser): string
    {
        $blogManager = new BlogsManager();
        $blogs = $blogManager->selectBlogsOfUser($idUser);
        return $this->twig->render('Blog/index.html.twig', [
            'blogs' => $blogs,
            'explore' => false,
            'owner' => true,
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
    public function add($idUser): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $errors = [];
            $uploadDir = 'upload/';
            $baseDir = (dirname((dirname(__DIR__)))) . '/public/';
            if (!is_dir($baseDir . '/upload')) {
                mkdir($baseDir . '/upload', 0777);
            }
            $extension = pathinfo($_FILES['bg-image']['name'], PATHINFO_EXTENSION);
            $uploadFile = $uploadDir . uniqid() . '.' . $extension;
            $authorizedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            $newBlog = array_map('trim', $_POST);

            if (strlen($newBlog['Title']) === 0  || strlen($newBlog['Title']) > 85) {
                $errors[] = 'Le titre du blog doit faire au minimum 2 caractères et maximum 85 caractères';
            }
            if (isset($newBlog['visibility'])) {
                $newBlog['visibility'] = true;
            } else {
                $newBlog['visibility'] = false;
            }

            $errors = $this->validate($newBlog, $extension, $authorizedExtensions);

            if (!move_uploaded_file($_FILES['bg-image']['tmp_name'], $baseDir . $uploadFile)) {
                $errors[] = $baseDir . $uploadFile;
            }

            $dataBlogSecure = [];
            $dataBlogSecure['Title'] = htmlentities($newBlog['Title']);
            $dataBlogSecure['Description'] = htmlentities($newBlog['Description']);
            $dataBlogSecure['Typo-title'] = $newBlog['Typo-title'];
            $dataBlogSecure['colorRef'] = $newBlog['colorRef'];
            $dataBlogSecure['visibility'] = $newBlog['visibility'];

            if (empty($errors)) {
                $imageBlog = $uploadFile;
                $dateCreation = new DateTimeImmutable('now');
                $dateFormat = $dateCreation->format("Y-m-d");
                $blogManager = new BlogsManager();
                $idBlog = $blogManager->insert($dataBlogSecure, $dateFormat, $idUser, $imageBlog);
                header('Location:/article/create?id=' . $idBlog);
                return null;
            }
        }
        return $this->twig->render('Blog/create-blog.html.twig');
    }

    private function validate(array $newBlog, string $extension, array $authorizedExtensions)
    {
        $maxFileSize = 1000000;
        $errors = [];
        if ($_FILES['bg-image']['error'] !== 0) {
            $errors[] = "Erreur de transfert de fichier. L'article n'a pas été ajouté.";
        }
        if (strlen($newBlog['Title']) === 0  || strlen($newBlog['Title']) > 255) {
            $errors[] = "Le titre de l'article doit faire au minimum 2 caractères et maximum 255 caractères";
        }
        if (strlen($newBlog['Description']) === 0) {
            $errors[] = "le contenu de l'article ne peut pas être vide.";
        }
        if (!in_array($extension, $authorizedExtensions)) {
            $errors[] = 'Selectionnez une image de type JPG, JPEG, PNG, OU WEBP.';
        }
        if (
            file_exists($_FILES['bg-image']['tmp_name']) &&
            filesize($_FILES['bg-image']['tmp_name']) > $maxFileSize
        ) {
            $errors[] = "Votre image est trop lourde 1Mo max.";
        }

        return $errors;
    }

    /**
     * Delete a Blog
     */

    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = trim($_GET['id']);
            $idUser = $_SESSION['userid'];
            $blogManager = new BlogsManager();
            $blogManager->delete((int)$id);
            header('Location:/profil?idUser=' . $idUser);
        }
    }
}
