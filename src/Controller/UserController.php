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
            $city = trim($_POST['city']);
            $phoneNumber = trim($_POST['phone_number']);

            if (empty($email)) {
                $errors['email'] = "vous devez rentrer un email";
            }
            if (empty($password)) {
                $errors['password'] = "vous devez saisir un mot de passe";
            } else {
                if (empty($password2)) {
                    $errors['password2'] = "vous devez confirmer votre mot de passe";
                } elseif ($password !== $password2) {
                    $errors['password2'] = "votre mot de passe et votre mot de passe de confirmation sont différents";
                }
            }
            if (empty($firstname)) {
                $errors['firstname'] = "vous devez rentrer votre prénom";
            }
            if (empty($lastname)) {
                $errors['lastname'] = "vous devez rentrer votre nom";
            }
            if (empty($city)) {
                $errors['city'] = "vous devez rentrer la ville la plus proche de chez vous";
            }
            if (empty($phoneNumber)) {
                $errors['phoneNumber'] = "vous devez rentrer votre numero de téléphone";
            }
            if (empty($errors)) {
                // insert user in DB
                $userManager = new UserManager();
                try {
                    $userManager->insertUser(['email' => $email, 'password' => $password]);
                    header("Location: /");
                } catch (\PDOException $e) {
                    $errors['form'] = $e->getMessage();
                }
            }
        }

        return $this->twig->render("Account/signUp.html.twig", [
            'errors' => $errors,
            'departments' => $departments,
            'citiesByDepartment' => $citiesByDepartment,
            'data' => [
                'email' => $email,
            ]
        ]);
    }
}
