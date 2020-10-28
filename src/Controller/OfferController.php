<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 16:07
 * PHP version 7
 */

namespace App\Controller;

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
        $categories = [
            'tools' => ['toolsCategoryA', 'toolsCategoryB', 'toolsCategoryC'],
            'materials' => ['materialsCategoryA', 'materialsCategoryB', 'materialsCategoryC']
        ];

        $transactions = ['A louer', 'A vendre'];

        $offers = [
            0 => ['title' => "nomAnnonce1", 'department' => "Rhone"],
            1 => ['title' => "nomAnnonce2", 'department' => "Isère"],
            2 => ['title' => "nomAnnonce3", 'department' => "Ain"]
        ];

        $errors = [];
        $product = $category = $transaction = $department = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-index-search']) && !empty($_POST)) {
            if (!isset($_POST['product'])) {
                $errors['product'] = 'Veuillez choisir un type de produit';
            } else {
                $product = $_POST['product'];
            }

            if (!isset($_POST['tools_categories']) && !isset($_POST['materials_categories'])) {
                $errors['category'] = 'Veuillez choisir une catégorie de produit';
            } elseif (isset($_POST['tools_categories'])) {
                $category = $_POST['tools_categories'];
            } else {
                $category = $_POST['materials_categories'];
            }
            $transaction = $_POST['transaction'];
            $department = $_POST['department'];

            if (empty($errors)) {
                header('Location:/offer/search');
            }
        }

        $offerInfos = [
            'product' => $product,
            'category' => $category,
            'transaction' => $transaction,
            'department' => $department
        ];

        return $this->twig->render('Offer/index.html.twig', [
            'offers' => $offers,
            'transactions' => $transactions,
            'categories' => $categories,
            'errors' => $errors,
            'offerInfos' => $offerInfos
        ]);
    }


    public function search()
    {
        return $this->twig->render('Offer/search.html.twig');
    }
}
