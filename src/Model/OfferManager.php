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

    /**
     *  insert user offer datas into DB
     *
     *  @param array $offerInfos
     *  @return int
     */
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

    public function selectOfferByResearchForm($offerInfos)
    {
        $statement = $this->pdo->prepare("SELECT " . self::TABLE . ".id AS offer_id, title, description,
        price, created_at, city.name AS city_name, firstname, lastname, email, phone_number FROM " . self::TABLE .
        " INNER JOIN product ON " . self::TABLE . ".product_id = product.id
        INNER JOIN transaction ON " . self::TABLE .".transaction_id = transaction.id
        INNER JOIN user ON " . self::TABLE . ".user_id = user_id
        INNER JOIN city ON user.city_id = city.id
        WHERE product.name = :product
        AND transaction.name = :transaction
        AND city.name = :city
        ORDER BY offer.title ASC");
        $statement->bindValue('product', $offerInfos['product'], \PDO::PARAM_STR);
        $statement->bindValue('transaction', $offerInfos['transaction'], \PDO::PARAM_STR);
        $statement->bindValue('city', $offerInfos['city'], \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function selectOneWithDetailsById($id)
    {
        $statement = $this->pdo->prepare("SELECT " .self::TABLE . ".id, title, description, price,
         user_id as seller_id, product.name as product_name, transaction.name as transaction_name
         FROM " . self::TABLE .
        " INNER JOIN product ON " . self::TABLE . " .product_id = product.id
        INNER JOIN transaction ON " . self::TABLE ." .transaction_id = transaction.id
        WHERE " .  self::TABLE . ".id=:id ");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        $resultOffer = $statement->fetch();
        return $resultOffer;
    }

    /**
     * get all offers from a user
     * @param int $userId
     * @return array
     */
    public function selectAllByUserId(int $userId): array
    {
        $statement = $this->pdo->prepare("SELECT " . self::TABLE . ".id AS offer_id, title, description,
        price, created_at, product.name as product_name, transaction.name as transaction_name FROM " . self::TABLE .
        " INNER JOIN product ON " . self::TABLE . ".product_id = product.id
        INNER JOIN transaction ON " . self::TABLE . ".transaction_id = transaction.id
        WHERE " . self::TABLE . ".user_id = :userId
        ORDER BY created_at DESC");
        $statement->bindValue('userId', $userId, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
}
