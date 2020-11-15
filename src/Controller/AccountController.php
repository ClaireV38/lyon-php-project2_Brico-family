<?php

namespace App\Controller;

class AccountController extends AbstractController
{
    public function signIn()
    {
        $errors = [];
        $email = $password = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-signIn']) && !empty($_POST)) {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            if (empty($email)) {
                $errors['email'] = "Veuillez renseigner votre email";
            }
            if (empty($password)) {
                $errors['password'] = "Veuillez renseigner votre mot de passe";
            }
            if (empty($errors)) {
                header('Location:/home/index/');
            }
        }
        $signInInfos = [
            'email' => $email,
            'password' => $password
        ];
        return $this->twig->render('Account/signIn.html.twig', [
            'signInInfos' => $signInInfos,
            'errors' => $errors,
        ]);
    }

    public function profil()
    {
        return $this->twig->render('Account/profil.html.twig');
    }

    public function signUp()
    {
        return $this->twig->render('Account/signUp.html.twig');
    }
}
