<?php

namespace App\Controller;

use App\Model\ProductManager;
use App\Model\TransactionManager;
use App\Model\OfferManager;
use App\Model\DepartmentManager;
use App\Model\CityManager;

class OfferController extends AbstractController
{
    /**
     * Display form for the user to add on offer and insert it into DB
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */

    public function add()
    {
        $productManager = new ProductManager();
        $toolproducts = $productManager->selectByProductType('Tool');
        $materialproducts = $productManager->selectByProductType('Material');

        $products = [
            'tools' => $toolproducts,
            'materials' => $materialproducts
        ];

        $transactionManager = new TransactionManager();
        $transactions = $transactionManager->selectAll();

        $errors = [];
        $productType = $product = $offerTitle = $transaction = $description = $price = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-add']) && !empty($_POST)) {
            if (!isset($_POST['tools_products']) && !isset($_POST['materials_products'])) {
                $errors['product'] = 'Veuillez choisir une catégorie de produit';
            }
            if (!isset($_POST['product_type'])) {
                $errors['productType'] = 'Veuillez choisir un type de produit';
            } else {
                $productType = $_POST['product_type'];
                if (isset($_POST['tools_products']) && $productType === 'tool') {
                    $product = $_POST['tools_products'];
                } else {
                    if (isset($_POST['materials_products'])) {
                        $product = $_POST['materials_products'];
                    }
                }
            }
            if (!isset($_POST['transaction'])) {
                $errors['transaction'] = 'Veuillez choisir un type de transaction';
            } else {
                $transaction = $_POST['transaction'];
            }
            $offerTitle = trim($_POST['offerTitle']);
            $description = trim($_POST['description']);
            $price = trim($_POST['price']);
            if (empty($offerTitle)) {
                $errors['offerTitle'] = "Veuillez renseigner le titre de votre annonce";
            }
            if (empty($description)) {
                $errors['description'] = "Veuillez renseigner une description";
            }
            if (empty($price)) {
                $errors['price'] = "Veuillez renseigner un prix à votre produit";
            }
            if (empty($errors)) {
                $offerInfos = [
                    'product' => $product,
                    'productType' => $productType,
                    'transaction' => $transaction,
                    'offerTitle' => $offerTitle,
                    'description' => $description,
                    'price' => $price,
                    'userId' => 1
                ];
                $offerManager = new OfferManager();
                $offerManager->insert($offerInfos);
                header('Location:/offer/addSuccess/');
            }
        }
        $offerInfos = [
            'product' => $product,
            'productType' => $productType,
            'transaction' => $transaction,
            'offerTitle' => $offerTitle,
            'description' => $description,
            'price' => $price
        ];

        return $this->twig->render('Offer/add.html.twig', [
            'transactions' => $transactions,
            'products' => $products,
            'errors' => $errors,
            'offerInfos' => $offerInfos,
        ]);
    }


    /**
     * Display success message for the user after adding an offer
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function addSuccess()
    {
        return $this->twig->render('Offer/addSuccess.html.twig');
    }

    /**
     * Display offers corresponding
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function results()
    {
        $productManager = new ProductManager();
        $toolproducts = $productManager->selectByProductType('Tool');
        $materialproducts = $productManager->selectByProductType('Material');

        $products = [
            'tools' => $toolproducts,
            'materials' => $materialproducts
        ];

        $transactionManager = new TransactionManager();
        $transactions = $transactionManager->selectAll();

        $departmentManager = new DepartmentManager();
        $departments = $departmentManager->selectAllOrderedByName();

        $cityManager = new CityManager();
        $citiesByDepartment = [];
        foreach ($departments as $department) {
            $citiesByDepartment[$department['name']] = $cityManager->selectCityByDepartement($department['name']);
        }

        $errors = [];
        $productType = $product = $transaction = $department = $city = "";
        $resultsOffer = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-index-search']) && !empty($_POST)) {
            if (!isset($_POST['tools_products']) && !isset($_POST['materials_products'])) {
                $errors['product'] = 'Veuillez choisir une catégorie de produit';
            }
            if (!isset($_POST['product_type'])) {
                $errors['productType'] = 'Veuillez choisir un type de produit';
            } else {
                $productType = $_POST['product_type'];
                if (isset($_POST['tools_products']) && $productType === 'tool') {
                    $product = $_POST['tools_products'];
                } else {
                    if (isset($_POST['materials_products'])) {
                        $product = $_POST['materials_products'];
                    }
                }
            }

            if (!isset($_POST['transaction'])) {
                $errors['transaction'] = 'Veuillez choisir un type de transaction';
            } else {
                $transaction = $_POST['transaction'];
            }

            if (!isset($_POST['city'])) {
                $errors['city'] = 'Veuillez choisir une ville';
            } else {
                $city = $_POST['city'];
            }

            if (empty($errors)) {
                $offerInfos = [
                    'product' => $product,
                    'productType' => $productType,
                    'transaction' => $transaction,
                    'department' => $department,
                    'city' => $city
                ];
                $offerManager = new OfferManager();
                $resultsOffer = $offerManager->selectOfferByResearchForm($offerInfos);
            }
        }
        $offerInfos = [
            'product' => $product,
            'productType' => $productType,
            'transaction' => $transaction,
            'department' => $department,
            'city' => $city
        ];

        return $this->twig->render('Offer/results.html.twig', [
            'departments' => $departments,
            'citiesByDepartment' => $citiesByDepartment,
            'transactions' => $transactions,
            'products' => $products,
            'errors' => $errors,
            'offerInfos' => $offerInfos,
            'resultsOffer' => $resultsOffer
        ]);
    }
}
