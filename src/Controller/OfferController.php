<?php

namespace App\Controller;

use App\Model\ProductManager;
use App\Model\TransactionManager;
use App\Model\OfferManager;
use App\Model\ImageManager;

class OfferController extends AbstractController
{
    /**
     * Display form for the user to add on offer and insert it into DB
     * Add images from offer into DB
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

        $imageErrors = [];
        $advice = [];
        $errors = [];
        $offerImages = [];
        $productType = $product = $offerTitle = $transaction = $description = $price = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
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
            if (empty($_FILES['images']['name'][0])) {
                $advice['images'] = "Sachez qu'une annonce est 5 fois plus consultée si elle contient des photos.";
            }
            if (!empty($_FILES['images']['name'][0])) {
                $images = $_FILES['images'];
                $allowed = ['jpeg', 'png', 'jpg', 'pdf'];
                foreach ($images['name'] as $index => $imagesName) {
                    $uploadStatus = $images['error'][$index]; //1 == error
                    if ($uploadStatus) {
                        $imageErrors[$imagesName] = "Une erreur est survenue. 
                        Impossible de charger le fichier: $imagesName";
                        continue;
                    }
                    $imagesTmp = $images['tmp_name'][$index];
                    $imagesSize = $images['size'][$index];
                    $imagesError = $images['error'][$index];
                    $tempName = $_FILES['images']['tmp_name'][$index];
                    $type = mime_content_type($tempName);
                    $imagesExt = explode('/', $type)[1];
                    $imagesNameNew = uniqid('') . '.' . $imagesExt;
                    $imagesDestination = 'uploads/' . $imagesNameNew;
                    if (!in_array($imagesExt, $allowed)) {
                        $imageErrors[$index] = "$imagesExt n'est pas autorisée-Extensions acceptées: jpg, jpeg et png";
                    }
                    if ($imagesSize >= 1000000) {
                        $imageErrors[$index] = "$imagesName La taille de l'image doit être inférieur à 1Mo. 
                        Taille actuelle du fichier = " . round($imagesSize / 1000000, 2) . "Mo.";
                    }
                    if ($imagesError !== 0) {
                        $imageErrors[$index] = "$imagesError - Une erreur est survenue avec l'image $imagesName.";
                    }
                    if (empty($imageErrors)) {
                        move_uploaded_file($imagesTmp, $imagesDestination);
                        $offerImages[] = [
                            'name' => $imagesNameNew,
                            'path' => $imagesDestination,
                        ];
                    }
                }
            }
            if (empty($errors) && empty($imageErrors)) {
                $offerInfos = [
                    'product' => $product,
                    'productType' => $productType,
                    'transaction' => $transaction,
                    'offerTitle' => $offerTitle,
                    'description' => $description,
                    'price' => $price,
                    'userId' => 1,
                ];

                $offerManager = new OfferManager();
                $imageManager = new ImageManager();
                $id = $offerManager->insert($offerInfos);
                if (!empty($offerImages)) {
                    foreach ($offerImages as $image) {
                        $imageManager->insertImages($image, $id);
                    }
                }
                header('Location:/offer/addSuccess/');
            }
        }
        $offerInfos = [
            'product' => $product,
            'productType' => $productType,
            'transaction' => $transaction,
            'offerTitle' => $offerTitle,
            'description' => $description,
            'price' => $price,
        ];
        return $this->twig->render('Offer/add.html.twig', [
            'transactions' => $transactions,
            'products' => $products,
            'errors' => $errors,
            'offerInfos' => $offerInfos,
            'advice' => $advice,
            'imageErrors' => $imageErrors
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
}
