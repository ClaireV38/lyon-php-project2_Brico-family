<?php


namespace App\Controller;

class UserController extends AbstractController
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
        ];
        return $this->twig->render('User/signIn.html.twig', [
            'signInInfos' => $signInInfos,
            'errors' => $errors,
        ]);
    }

    public function signUp()
    {
        return $this->twig->render('User/signUp.html.twig');
    }
}
