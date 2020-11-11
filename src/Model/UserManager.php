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
    public function selectOneWithLocationById(int $id)
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
}
