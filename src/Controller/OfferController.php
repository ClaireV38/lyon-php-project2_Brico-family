<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

use App\Model\ProductManager;
use App\Model\TransactionManager;
use App\Model\DepartmentManager;
use App\Model\OfferManager;

/**
 * Class OfferController
 *
 */
class OfferController extends AbstractController
{


    /**
     * Display list Offers
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function results()
    {
        return $this->twig->render('Offer/results.html.twig');
    }

    public function add()
    {
        return $this->twig->render('Offer/add.html.twig');
    }

    /**
     * Display offer informations specified by $id
     *
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function details(int $id = 1)
    {
        $offerManager = new OfferManager();
        $item = $offerManager->selectOneById($id);

        return $this->twig->render('Item/show.html.twig', ['item' => $item]);
    }
}
