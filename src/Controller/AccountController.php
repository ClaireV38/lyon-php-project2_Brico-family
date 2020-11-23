<?php

namespace App\Controller;

use App\Model\UserManager;
use App\Model\OfferManager;
use App\Model\ImageManager;

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
        $offerManager = new OfferManager();
        $userOffers = $offerManager->selectAllByUserId(intval($user['id']));
        $imageManager = new ImageManager();
        foreach ($userOffers as $key => $userOffer) {
            $userOffer['images'] = $imageManager->selectAllByOfferId($userOffer['offer_id']);
            $userOffers[$key] = $userOffer;
        }
        return $this->twig->render('Account/profil.html.twig', ['userOffers' => $userOffers]);
    }
}
