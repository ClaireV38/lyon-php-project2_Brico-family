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
    const TABLE = 'category';

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
     * @param  string $productName
     *
     * @return array
     */
    public function selectByProductType(string $productName)
    {
        // prepared request
        $statement = $this->pdo->query("SELECT " . self::TABLE . ".name  FROM ". self::TABLE .
        " INNER JOIN product ON " . self::TABLE . ".product_id = product.id
        WHERE product.name = '". $productName .
        "' ORDER BY " . self::TABLE . ".name ASC");

        return $statement->fetchAll();
    }
}
