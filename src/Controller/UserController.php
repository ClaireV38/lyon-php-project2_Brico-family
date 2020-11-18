<?php

namespace App\Controller;

use App\Model\CityManager;
use App\Model\DepartmentManager;
use App\Model\UserManager;

class UserController extends AbstractController
{
    public function register()
    {
        if (isset($_SESSION['user'])) {
            header("Location: /");
        }

        $departmentManager = new DepartmentManager();
        $departments = $departmentManager->selectAllOrderedByName();

        $cityManager = new CityManager();
        $citiesByDepartment = [];
        foreach ($departments as $department) {
            $citiesByDepartment[$department['name']] = $cityManager->selectCityByDepartement($department['name']);
        }

        $email = $password = $password2 = $firstname = $lastname = $city = $phoneNumber = "";
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === "POST" && !empty($_POST) && isset($_POST['btn-register'])) {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $password2 = trim($_POST['password2']);
            $firstname = trim($_POST['firstname']);
            $lastname = trim($_POST['lastname']);
            $phoneNumber = trim($_POST['phone_number']);

            if (!isset($_POST['city'])) {
                $errors['city'] = "vous devez rentrer la ville la plus proche de chez vous";
            } else {
                $city = trim($_POST['city']);
            }

            if (empty($email)) {
                $errors['email'] = "vous devez rentrer un email";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "votre format de mot de passe est invalide";
            }
            if (empty($password)) {
                $errors['password'] = "vous devez saisir un mot de passe";
            } elseif (!preg_match("/^(?=.*[0-9])(?=.*[A-Z]).{8,20}$/i", $password)) {
                $errors['password'] = "Votre mot de passe doit être entre 8 et 20 caractères et doit contenir 
                au un chiffre";
            } else {
                if (empty($password2)) {
                    $errors['password2'] = "vous devez confirmer votre mot de passe";
                } elseif ($password !== $password2) {
                    $errors['password2'] = "votre mot de passe et votre mot de passe de confirmation sont différents";
                }
            }
            if (empty($firstname)) {
                $errors['firstname'] = "vous devez rentrer votre prénom";
            } elseif (mb_strlen($firstname) > 30) {
                $errors['firstname'] = "ce champ ne doit pas dépasser 30 caractères";
            }
            if (empty($lastname)) {
                $errors['lastname'] = "vous devez rentrer votre nom";
            } elseif (mb_strlen($lastname) > 30) {
                $errors['lastname'] = "ce champ ne doit pas dépasser 30 caractères";
            }
            if (empty($phoneNumber)) {
                $errors['phoneNumber'] = "vous devez rentrer votre numero de téléphone";
            } elseif (!preg_match("/^(0[1-68])(?:[ _.-]?(\d{2})){4}$/i", $phoneNumber)) {
                $errors['phoneNumber'] = "Votre numero de telephone n'est pas valide";
            }
            if (empty($errors)) {
                    header("Location: /");
            }
        }

        return $this->twig->render("Account/signUp.html.twig", [
            'errors' => $errors,
            'departments' => $departments,
            'citiesByDepartment' => $citiesByDepartment,
            'data' => [
                'email' => $email,
                'password' => $password,
                'password2' => $password2,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'city' => $city,
                "phoneNumber" => $phoneNumber
            ]
        ]);
    }
}
