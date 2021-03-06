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
class ProductManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'product';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * Get one row from database by product.
     *
     * @param  string $productTypeName
     *
     * @return array
     */
    public function selectByProductType(string $productTypeName)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT " . self::TABLE . ".name  FROM ". self::TABLE .
        " INNER JOIN product_type ON " . self::TABLE . ".product_type_id = product_type.id
        WHERE product_type.name = :productTypeName 
        ORDER BY " . self::TABLE . ".name ASC");
        $statement->bindValue('productTypeName', $productTypeName, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll();
    }
}
