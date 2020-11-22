<?php

namespace App\Controller;

use App\Model\UserManager;
use App\Model\OfferManager;

class AccountController extends AbstractController
{
    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function profil(): string
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /");
        }
        $user = $this->getUser();
        var_dump($user);
        $offerManager = new OfferManager();
        $userOffers = $offerManager->selectAllByUserId(intval($user['id']));
        var_dump($userOffers);
        return $this->twig->render('Account/profil.html.twig', ['userOffers' => $userOffers]);
    }
}
