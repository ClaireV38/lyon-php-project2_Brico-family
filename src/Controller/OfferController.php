<?php

namespace App\Controller;

use App\Model\ProductManager;
use App\Model\TransactionManager;
use App\Model\DepartmentManager;
use App\Model\OfferManager;
use App\Model\UserManager;
use App\Model\ImageManager;

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
        return $this->twig->render('Offer/results.html.twig');
    }

    /**
     * Display offer informations specified by $id
     *
     * @param string $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function details(string $id = '2')
    {
        $id = intval(trim($id));

        $offerManager = new OfferManager();
        $detailsOffer = $offerManager->selectOneWithDetailsById($id);

        $imageManager = new ImageManager();
        $offerImages = $imageManager->selectAllByOfferId($id);


        function resize_image(string $imagePath, int $newWidth, int $newHeight, string $destPath)
        {
            list($width, $height) = getimagesize($imagePath);
            $newwidth = 500;
            $newheight = 300;

            $thumb = imagecreatetruecolor($newWidth, $newHeight);
            $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
            if ($extension !== 'jpg' && $extension !== 'png' && $extension !== 'jpeg') {
                return "file type error";
            } elseif ($extension == 'png') {
                $source = imagecreatefrompng($imagePath);
            } else {
                $source = imagecreatefromjpeg($imagePath);
            }

            imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

            imagejpeg($thumb, $destPath);
        }

       // foreach ($offerImages as $image) {
       //     resize_image("." . $image['path'], 500, 300, "./assets/uploads/miniatures/" . $image['name']);
       // }

        $sellerShow="";
        $sellerDetails = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_seller_show']) && !empty($_POST)) {
            $sellerShow = trim($_POST['seller_show']);
            $userManager = new UserManager();
            $sellerDetails = $userManager->selectOneWithLocationById($detailsOffer['seller_id']);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_seller_hide']) && !empty($_POST)) {
            $sellerShow = trim($_POST['seller_hide']);
        }

        return $this->twig->render('Offer/details.html.twig', [
        'detailsOffer' => $detailsOffer,
        'sellerShow' => $sellerShow,
        'sellerDetails' => $sellerDetails,
        'images' => $offerImages]);
    }
}
