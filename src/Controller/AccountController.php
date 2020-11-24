<?php

namespace App\Controller;

use App\Model\CityManager;
use App\Model\DepartmentManager;
use App\Model\UserManager;
use App\Model\OfferManager;
use App\Model\ImageManager;

class AccountController extends AbstractController
{
    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function profil(): string
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /");
        }
        $user = $this->getUser();
        $userManager = new UserManager();
        $user = $userManager->selectOneWithLocationById($user['id']);
        $offerManager = new OfferManager();
        $userOffers = $offerManager->selectAllByUserId(intval($user['id']));
        $imageManager = new ImageManager();
        foreach ($userOffers as $key => $userOffer) {
            $userOffer['images'] = $imageManager->selectAllByOfferId($userOffer['offer_id']);
            $userOffers[$key] = $userOffer;
        }
        return $this->twig->render('Account/profil.html.twig', ['user' => $user, 'userOffers' => $userOffers]);
    }

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function update(): string
    {
        $user = $this->getUser();
        $userManager = new UserManager();
        $data = $userManager->selectOneWithLocationById($user['id']);

        $departmentManager = new DepartmentManager();
        $departments = $departmentManager->selectAllOrderedByName();

        $cityManager = new CityManager();
        $citiesByDepartment = [];
        foreach ($departments as $department) {
            $citiesByDepartment[$department['name']] = $cityManager->selectCityByDepartement($department['name']);
        }

        $email = $firstname = $lastname = $city = $phoneNumber = "";
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === "POST" && !empty($_POST) && isset($_POST['btn-update'])) {
            $email = trim($_POST['email']);
            $lastname = strtoupper(trim($_POST['lastname']));
            $firstname = ucfirst(strtolower(trim($_POST['firstname'])));
            $phoneNumber = str_replace(' ', '', trim($_POST['phone_number']));

            if (!isset($_POST['city'])) {
                $errors['city'] = "vous devez rentrer la ville la plus proche de chez vous";
            } else {
                $city = trim($_POST['city']);
            }
            if (empty($email)) {
                $errors['email'] = "vous devez rentrer un email";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "votre format d'email est invalide";
            }
            if (empty($firstname)) {
                $errors['firstname'] = "Vous devez rentrer votre prénom";
            } elseif (mb_strlen($firstname) > 30) {
                $errors['firstname'] = "Ce champ ne doit pas dépasser 30 caractères";
            }
            if (empty($lastname)) {
                $errors['lastname'] = "Vous devez rentrer votre nom";
            } elseif (mb_strlen($lastname) > 30) {
                $errors['lastname'] = "Ce champ ne doit pas dépasser 30 caractères";
            }
            if (empty($phoneNumber)) {
                $errors['phoneNumber'] = "Vous devez rentrer votre numero de téléphone";
            } elseif (!preg_match("/^(0[1-68])(?:[ _.-]?(\d{2})){4}$/i", $phoneNumber)) {
                $errors['phoneNumber'] = "Votre numéro de téléphone n'est pas valide";
            }
            $data = [
                'id' => $user['id'],
                'email' => $email,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'user_city' => $city,
                'phone_number' => $phoneNumber
            ];
            if (empty($errors)) {
                $userManager = new UserManager();
                var_dump($data);
                try {
                    $userManager->updateUser($data);
                    $_SESSION['user'] = [
                        'email' => $email,
                    ];
                    header("Location: /Account/profil");
                } catch (\PDOException $e) {
                    $errors['form'] = $e->getMessage();
                }
            }
        }
        return $this->twig->render('Account/update.html.twig', [
            'departments' => $departments,
            'citiesByDepartment' => $citiesByDepartment,
            'data' => $data,
            'errors' => $errors
        ]);
    }
}
