<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    public function signin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Clean POST data into array
            $errors = [];
            $credentials = array_map('trim', $_POST);
            //form validation
            if (empty($credentials['email'])) {
                $errors[] = "Veuillez entrer votre email";
            }
            if (empty($credentials['password'])) {
                $errors[] = "Veuillez entrer votre mot de passe";
            }
            if (empty($errors)) {
            }
        }
        return $this->twig->render('User/signin.html.twig');
    }

    public function signup()
    {
        $errors = [];
        $securedCredentials = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $uploadDir = 'upload/';
            $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
            $uploadFile = $uploadDir . uniqid() . '.' . $extension;
            $authorizedExtensions = ['jpg', 'png', 'webp'];

            $credentials = array_map('trim', $_POST);

            $errors = $this->validate($credentials, $extension, $authorizedExtensions);
            var_dump($errors);
            $securedCredentials['name'] = htmlentities($credentials['name']);
            $securedCredentials['email'] = htmlentities($credentials['email']);
            $securedCredentials['password'] = $credentials['password'];
            $securedCredentials['image'] = $uploadFile;

            if (empty($errors)) {
                move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
                $userManager = new userManager();
                $userManager->insert($securedCredentials);
            }
        }
        return $this->twig->render('User/signup.html.twig');
    }

    private function validate(array $credentials, string $extension, array $authExtensions)
    {
        $maxFileSize = 1000000;
        $errors = [];

        if (empty($credentials['email']) && !filter_var($credentials['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Veuillez entrer votre email";
        }
        if (empty($credentials['name'])) {
            $errors[] = "Veuillez entrer votre nom";
        }
        if (empty($credentials['password'])) {
            $errors[] = "Veuillez entrer votre mot de passe";
        }
        if (!in_array($extension, $authExtensions)) {
            $errors[] = 'Selectionnez une image de type JPG, PNG OU WEBP.';
        }
        if (file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize) {
            $errors[] = "Votre image est trop lourde 1Mo max.";
        }

        return $errors;
    }
}
