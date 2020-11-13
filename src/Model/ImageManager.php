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
     * Get all images corresponding to an offer.
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
