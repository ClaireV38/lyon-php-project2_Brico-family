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
        $statement = $this->pdo->prepare("SELECT id FROM product WHERE name = :productName");
        $statement->bindValue('productName', $offerInfos['product'], \PDO::PARAM_STR);
        $statement->execute();
        $productName = $statement->fetch();

        $statement = $this->pdo->prepare("SELECT id FROM transaction WHERE name = :transactionName");
        $statement->bindValue('transactionName', $offerInfos['transaction'], \PDO::PARAM_STR);
        $statement->execute();
        $transactionName = $statement->fetch();

        $statement= $this->pdo->prepare("INSERT INTO " . self::TABLE . "(title, description, price, user_id,
        product_id, transaction_id) VALUES (:title, :description, :price, :userId, :productId, :transactionId)");
        $statement->bindValue('title', $offerInfos['offerTitle'], \PDO::PARAM_STR);
        $statement->bindValue('description', $offerInfos['description'], \PDO::PARAM_STR);
        $statement->bindValue('price', $offerInfos['price'], \PDO::PARAM_INT);
        $statement->bindValue('userId', $offerInfos['userId'], \PDO::PARAM_INT);
        $statement->bindValue('productId', $productName['id'], \PDO::PARAM_INT);
        $statement->bindValue('transactionId', $transactionName['id'], \PDO::PARAM_INT);
        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
