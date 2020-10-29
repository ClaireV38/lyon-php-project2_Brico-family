<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\OfferManager;

/**
 * Class OfferController
 *
 */
class OfferController extends AbstractController
{
    /**
     * Display item listing
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        //   $offerManager = new OfferManager();
        //  $offers = $offerManager->selectAll();

        $offers = [
            0 => ['name' => "nomAnnonce1", 'category' => "nomCategorieA", 'departement' => "Rhone"],
            1 => ['name' => "nomAnnonce2", 'category' => "nomCategorieB", 'departement' => "Isère"],
            2 => ['name' => "nomAnnonce3", 'category' => "nomCategorieA", 'departement' => "Ain"]
        ];

        return $this->twig->render('Offer/list.html.twig', ['offers' => $offers]);
    }
}
