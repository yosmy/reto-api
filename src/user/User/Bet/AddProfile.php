<?php

namespace Reto\User\Bet;

use MongoDB\Driver\Exception\BulkWriteException;

/**
 * @di\service()
 */
class AddProfile
{
    /**
     * @var SelectProfileCollection
     */
    private $selectProfileCollection;

    /**
     * @param SelectProfileCollection $selectProfileCollection
     */
    public function __construct(
        SelectProfileCollection $selectProfileCollection
    ) {
        $this->selectProfileCollection = $selectProfileCollection;
    }

    /**
     * @param string $owner
     * @param int $balance In cents
     *
     * @throws ExistentProfileException
     */
    public function add(
        string $owner,
        int $balance
    ) {
        try {
            $this->selectProfileCollection->select()->insertOne([
                '_id' => $owner,
                'balance' => $balance
            ]);
        } catch (BulkWriteException $e) {
            $error = $e->getWriteResult()->getWriteErrors()[0];

            if ($error->getCode() == 11000) {
                if (strpos($error->getMessage(), 'index: _id_') !== false) {
                    throw new ExistentProfileException();
                }
            }

            throw $e;
        }
    }
}