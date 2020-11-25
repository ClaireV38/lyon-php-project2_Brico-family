<?php

namespace App\Controller;

use App\Model\ProductManager;
use App\Model\TransactionManager;
use App\Model\DepartmentManager;
use App\Model\CityManager;
use App\Model\OfferManager;
use App\Model\UserManager;
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
        if (!isset($_SESSION['user'])) {
            header("Location: /");
        }
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
            $price = str_replace(',', '.', trim($_POST['price']));

            if (empty($offerTitle)) {
                $errors['offerTitle'] = "Veuillez renseigner le titre de votre annonce";
            } elseif (mb_strlen($offerTitle) > 50) {
                $errors['offerTitle'] = "le titre de l'annonce ne doit pas dépasser 50 caractères";
            }
            if (empty($description)) {
                $errors['description'] = "Veuillez renseigner une description";
            } elseif (mb_strlen($description) > 250) {
                $errors['description'] = "la description ne doit pas dépasser 250 caractères";
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
                if (count($_FILES['images']['name']) > 5) {
                    $imageErrors[] =  'Un maximum de 5 photos est autorisé.';
                }
                foreach ($images['name'] as $index => $imagesName) {
                    $uploadStatus = $images['error'][$index];
                    $imagesSize = $images['size'][$index];
                    if ($imagesSize >= 1000000 || $uploadStatus === 1) {
                        $imageErrors[$index] = "$imagesName La taille de l'image doit être inférieur à 1Mo.";
                    } elseif ($uploadStatus !== 1 && $uploadStatus !== 0) {
                        $imageErrors[$imagesName] = "Une erreur est survenue.
                        Impossible de charger le fichier: $imagesName";
                        continue;
                    } else {
                        $imagesTmp = $images['tmp_name'][$index];
                        $tempName = $_FILES['images']['tmp_name'][$index];
                        $type = mime_content_type($tempName);
                        $imagesExt = explode('/', $type)[1];
                        $imagesNameNew = uniqid('') . '.' . $imagesExt;
                        $imagesDestination = 'uploads/' . $imagesNameNew;
                        if (!in_array($imagesExt, $allowed)) {
                            $imageErrors[$index] = "$imagesExt n'est pas autorisée - Extensions acceptées: 
                            jpg, jpeg et png";
                        }
                        if (empty($imageErrors)) {
                            move_uploaded_file($imagesTmp, $imagesDestination);
                            $offerImages[] = [
                                'name' => $imagesNameNew,
                                'path' => "/" . $imagesDestination,
                            ];
                        }
                    }
                }
            }
            if (empty($errors) && empty($imageErrors)) {
                $user = $this->getUser();
                $offerInfos = [
                    'product' => $product,
                    'productType' => $productType,
                    'transaction' => $transaction,
                    'offerTitle' => $offerTitle,
                    'description' => $description,
                    'price' => $price,
                    'userId' => $user['id'],
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
        $offerInfos = ['product' => $product,
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
        $errors = [];
        $productType = $product = $transaction = $department = $city = "";
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET)) {
            $productType = trim($_GET['productType']);
            $product = trim($_GET['product']);
            $transaction = trim($_GET['transaction']);
            $department = trim($_GET['department']);
            $city = trim($_GET['city']);
        }

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
            }
        }

        $offerInfos = [
            'product' => $product,
            'productType' => $productType,
            'transaction' => $transaction,
            'department' => $department,
            'city' => $city
        ];

        $offerManager = new OfferManager();
        $resultsOffer = $offerManager->selectOfferByResearchForm($offerInfos);
        if (empty($resultsOffer) && !empty($_POST)) {
            $errors['noResult'] = "aucune annonce ne correspond à votre recherche";
        }

        return $this->twig->render('Offer/results.html.twig', [
            'departments' => $departments,
            'citiesByDepartment' => $citiesByDepartment,
            'transactions' => $transactions,
            'products' => $products,
            'offerInfos' => $offerInfos,
            'errors' => $errors,
            'resultsOffer' => $resultsOffer
        ]);
    }

    /**
     * Display offer datas specified by $id
     *
     * @param string $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function details(string $id): string
    {
        $id = intval(trim($id));

        $offerManager = new OfferManager();
        $detailsOffer = $offerManager->selectOneWithDetailsById($id);

        $imageManager = new ImageManager();
        $offerImages = $imageManager->selectAllByOfferId($id);

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

    /**
     * delete offer selected by user
     */
    public function delete()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            header("HTTP/1.0 405 Method Not Allowed");
            exit();
        }

        if (!empty($_POST)) {
            $id = intval($_POST['id']);
            $offerManager = new OfferManager();
            $offerManager->delete($id);
        }
        header("Location:/account/profil");
    }
}
