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

        $email = $password = $password2 = "";
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === "POST" && !empty($_POST)) {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $password2 = trim($_POST['password2']);
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
