<?php

namespace App\Controller;

class AccountController extends AbstractController
{
    public function profil()
    {
        return $this->twig->render('Account/profil.html.twig');
    }
}
