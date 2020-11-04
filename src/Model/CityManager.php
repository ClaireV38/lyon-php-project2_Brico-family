<?php

namespace App\Model;

use App\Controller\AbstractController;

class CityManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'city';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * Get all cites of one department
     *
     * @return array
     */
    public function selectCityByDepartement($departmentName):array
    {
        $statement = $this->pdo->prepare("SELECT " . self::TABLE . ".name FROM " . self::TABLE .
            " INNER JOIN department ON department.id = " . self::TABLE . ".department_id 
            WHERE department.name = :departmentName ORDER BY " . self::TABLE . ".name ASC;");
        $statement->bindValue('departmentName', $departmentName, \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll();
    }
}
