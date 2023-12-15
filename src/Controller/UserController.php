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
            $password = $credentials['password'];

            if ($password === '') {
                $errors[] = 'Veuillez saisir un mot de passs';
            }
            if (empty($errors)) {
                $userManager = new UserManager();
                $user = $userManager->selectOneByEmail($email);
                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user id'] = $user['id'];
                    header('location: /');
                    exit();
                } else {
                    $errors[] = "L'utilisateur n'existe pas.";
                }
            }
        }
        return $this->twig->render('User/login.html.twig');
    }
}
