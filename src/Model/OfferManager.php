<?php

namespace App\Model;

class OfferManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'offer';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

        public function insert(array $offerInfos): int
    {
        $statement = $this->pdo->prepare("SELECT product.id FROM product WHERE product.id = :productId");
        $statement->bindValue('productId', $offerInfos['product'], \PDO::PARAM_STR);
        $statement->execute();
        $productId = $statement->fetch();

        $statement = $this->pdo->prepare("SELECT transaction.id FROM transaction WHERE transaction.id = :transactionId");
        $statement->bindValue('transactionId', $offerInfos['transaction'], \PDO::PARAM_STR);
        $statement->execute();
        $transactionId = $statement->fetch();

        $statement= $this->pdo->prepare("INSERT INTO " . self::TABLE . "(title, description, price, product_id, transaction_id) 
        VALUES (:title, :description, :price," . $productId . "," . $transactionId . ")");
        $statement->bindValue('title', $offerInfos['offerTitle'], \PDO::PARAM_STR);
        $statement->bindValue('description', $offerInfos['description'], \PDO::PARAM_STR);
        $statement->bindValue('price', $offerInfos['price'], \PDO::PARAM_INT);
        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
