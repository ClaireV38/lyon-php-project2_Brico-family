<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace App\Model;

/**
 *
 */
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
     * Get all row from database ordered by name
     *
     * @return array
     */
    public function selectAllOrderedByName(): array
    {
        $statement = $this->pdo->prepare('SELECT * FROM ' . self::TABLE . " ORDER BY name;");
        $statement->execute();

        return $statement->fetchAll();
    }
}
