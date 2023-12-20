<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    public function login(): string
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $credentials = array_map('trim', $_POST);
            if ($credentials['email'] === '' || !filter_var($credentials['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Veuillez saisir une addresse email valide';
            }
            $email = htmlentities($credentials['email']);

            if (!empty($credentials['password'])) {
                $password = $credentials['password'];
            } else {
                $errors[] = 'Veuillez saisir un mot de passe';
            }
            if ($password === '') {
                $errors[] = 'Veuillez saisir un mot de passs';
            }
            if (empty($errors)) {
                $userManager = new UserManager();
                $user = $userManager->selectOneByEmail($email);
                if ($user && password_verify($password, $user['Password'])) {
                    $_SESSION['userid'] = $user['idUsers'];
                    header('Location: /');
                    exit();
                } else {
                    $errors[] = "L'utilisateur n'existe pas.";
                }
            }
        }
        return $this->twig->render('User/login.html.twig');
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
            $securedCredentials['name'] = htmlentities($credentials['name']);
            $securedCredentials['email'] = htmlentities($credentials['email']);
            $securedCredentials['password'] = $credentials['password'];
            $securedCredentials['image'] = $uploadFile;

            if (empty($errors)) {
                move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
                $userManager = new userManager();
                if($userManager->insert($securedCredentials))
                {
                    $this->login();
                }
            }
        }
        return $this->twig->render('User/signup.html.twig');
    }

    public function logout()
    {
        unset($_SESSION['userid']);
        header('Location: /');
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
