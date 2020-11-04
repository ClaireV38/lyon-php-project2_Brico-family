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

    public function insert(array $offer): int
    {
        $statement= $this->pdo->prepare("INSERT INTO " . self::TABLE . "(title, description, price) 
        VALUES (:offerTitle, :description, :price)");
        $statement->bindValue('title', $offer['offerTitle'], \PDO::PARAM_STR);
        $statement->bindValue('description', $offer['description'], \PDO::PARAM_STR);
        $statement->bindValue('price', $offer['price'], \PDO::PARAM_STR);
        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
