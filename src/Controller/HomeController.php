<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\ProductManager;
use App\Model\DepartmentManager;
use App\Model\TransactionManager;
use App\Model\CityManager;
use App\Controller\OfferController;

class HomeController extends AbstractController
{

    /**
     * Display home form
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
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

            if (!isset($_POST['department'])) {
                $errors['department'] = 'Veuillez choisir un departement';
            } else {
                $department = $_POST['department'];
            }

            if (!isset($_POST['city'])) {
                $errors['city'] = 'Veuillez choisir une ville';
            } else {
                $city = $_POST['city'];
            }

            if (empty($errors)) {
                header("Location:/Offer/results/?product=$product&productType=$productType".
                "&transaction=$transaction&department=$department");
            }
        }
        $offerInfos = [
            'product' => $product,
            'productType' => $productType,
            'transaction' => $transaction,
            'department' => $department,
            'city' => $city
        ];

        return $this->twig->render('Home/index.html.twig', [
            'departments' => $departments,
            'citiesByDepartment' => $citiesByDepartment,
            'transactions' => $transactions,
            'products' => $products,
            'errors' => $errors,
            'offerInfos' => $offerInfos
        ]);
    }
}
