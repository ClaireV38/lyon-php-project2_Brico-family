<?php

namespace App\Model;

class UserManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'user';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
    
    /**
     * Get one user from database with his location by ID.
     *
     * @param  int $id
     *
     * @return array
     */
    public function selectOneWithLocationById(int $id): array
    {
        $statement = $this->pdo->prepare("SELECT " .self::TABLE . ".id, firstname, lastname, email,
         phone_number, city.name as user_city, department.name as user_department
          FROM ". self::TABLE .
          " JOIN city ON " .self::TABLE . ".city_id = city.id
          JOIN department ON city.department_id = department.id
          WHERE " .self::TABLE . ".id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    /**
     * Get one user from database with his location by email
     *
     * @param string $email
     * @return array
     */
    public function selectUserByEmail(string $email): array
    {
        $query = "SELECT * FROM " . self::TABLE . " WHERE email=:email";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue("email", $email, \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }

    /**
     *insert user with his datas in database
     *
     * @param array $user
     * @return int
     */
    public function insertUser(array $user): int
    {
        $query = "INSERT INTO " . self::TABLE . " (email, password) VALUES (:email, :password)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('email', $user['email'], \PDO::PARAM_STR);
        $statement->bindValue('password', password_hash($user['password'], PASSWORD_DEFAULT), \PDO::PARAM_STR);
        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
