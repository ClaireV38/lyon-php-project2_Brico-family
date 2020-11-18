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
class ImageManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'image';

    /**
     *  Initializes this class.
     */

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     *  insert images of offer into DB
     *
     *  @param array $offerImages
     *  @param int $offerId
     * @return int
     */
    public function insertImages(array $offerImages, int $offerId): int
    {
        $statement = $this->pdo->prepare("INSERT INTO image (name, path, offer_id) 
        VALUES (:name, :path, :offer_id)");
        $statement->bindValue('name', $offerImages['name'], \PDO::PARAM_STR);
        $statement->bindValue('path', $offerImages['path'], \PDO::PARAM_STR);
        $statement->bindValue('offer_id', $offerId, \PDO::PARAM_INT);
        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

     /** Get all images corresponding to an offer.
     *
     * @param  int $offerId
     *
     * @return array
     */
    public function selectAllByOfferId(int $offerId)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . self::TABLE . " WHERE offer_id=:offer_id");
        $statement->bindValue('offer_id', $offerId, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
}
