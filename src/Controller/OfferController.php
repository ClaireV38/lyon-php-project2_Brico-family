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
        $categories = [
            'tools' => ['toolsCategorieA' , 'toolsCategorieB' , 'toolsCategorieC' ],
            'materials' => ['materialsCategorieA' , 'materialsCategorieB' , 'materialsCategorieC' ]
        ];


        $offers = [
            0 => ['name' => "nomAnnonce1", 'department' => "Rhone"],
            1 => ['name' => "nomAnnonce2", 'department' => "Isère"],
            2 => ['name' => "nomAnnonce3", 'category' => "nomCategorieA", 'department' => "Ain"]
        ];

        $errors = [];
        $toolOrMaterial = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST'  && isset($_POST['btn-index-search'])  &&  !empty($_POST)) {
            var_dump($_POST);

            if (!isset($_POST['tool_or_material'])) {
                $errors['tool_or_material'] = 'Veuillez choisir un type de produit';
                $toolOrMaterial = $_POST['tool_or_material'];
            }
        }
        return $this->twig->render('Offer/index.html.twig', [
            'offers' => $offers ,'categories' => $categories, 'errors' => $errors]);
    }
}
