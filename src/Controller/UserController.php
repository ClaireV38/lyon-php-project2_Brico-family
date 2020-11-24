<?php

namespace App\Controller;

use App\Model\CityManager;
use App\Model\DepartmentManager;
use App\Model\UserManager;

class UserController extends AbstractController
{

  public function signIn()
    {
        $errors = [];
        $email = $password = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-signIn']) && !empty($_POST)) {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            if (empty($email)) {
                $errors['email'] = "Veuillez renseigner votre email";
            }
            if (empty($password)) {
                $errors['password'] = "Veuillez renseigner votre mot de passe";
            }
            if (empty($errors)) {
                $userManager = new UserManager();
                $user = $userManager->selectUserByEmail($email);
                if (!$user) {
                    $errors['email'] = "Nous ne vous avons pas trouvé ... Créer votre compte dès maintenant !";
                } elseif (!password_verify($password, $user['password'])) {
                    $errors['password'] = "Mauvais mot de passe";
                } else {
                    $_SESSION['user'] = [
                        'email' => $user['email'],
                    ];
                }
                    header('Location:/home/index/');
            }
        }
        $signInInfos = [
            'email' => $email,
        ];
        return $this->twig->render('User/signIn.html.twig', [
            'signInInfos' => $signInInfos,
            'errors' => $errors,
        ]);
    }

    public function signUp()
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
            $lastname = strtoupper(trim($_POST['lastname']));
            $firstname = ucfirst(strtolower(trim($_POST['firstname'])));
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
                au moins un chiffre";
            } else {
                if (empty($password2)) {
                    $errors['password2'] = "Vous devez confirmer votre mot de passe";
                } elseif ($password !== $password2) {
                    $errors['password2'] = "Votre mot de passe et votre mot de passe de confirmation sont différents";
                }
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
            if (empty($errors)) {
                $userManager = new UserManager();
                try {
                    $userManager->insertUser([
                        'email' => $email,
                        'password' => $password,
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'city' => $city,
                        "phoneNumber" => $phoneNumber
                    ]);
                    $_SESSION['user'] = [
                        'email' => $email,
                    ];
                    header("Location: /");
                } catch (\PDOException $e) {
                    $errors['form'] = $e->getMessage();
                }
            }
        }

        return $this->twig->render("User/signUp.html.twig", [
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

    public function logout()
    {
        session_destroy();
        header("Location: /");
    }
}
