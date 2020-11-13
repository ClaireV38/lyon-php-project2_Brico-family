<?php

namespace App\Controller;

class AccountController extends AbstractController
{
    public function signIn()
    {
        return $this->twig->render('Account/signIn.html.twig');
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
