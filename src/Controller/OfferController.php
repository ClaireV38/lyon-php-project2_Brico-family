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
use App\Model\CityManager;

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
    public function results($departmentName)
    {
        $departmentManager = new DepartmentManager();
        $departments = $departmentManager->selectAllOrderedByName();

        $cityManager = new CityManager();
        $cities = $cityManager->selectCityByDepartement($departmentName);

        return $this->twig->render('Offer/results.html.twig', [
        'departments' => $departments,
        'cities' => $cities,
        ]);
    }
}
