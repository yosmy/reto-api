<?php

namespace Reto\User\Bet\Profile;

use MongoDB\UpdateResult;
use Reto\User\Bet;

/**
 * @di\service({private: true})
 */
class ManageBalance
{
    /**
     * @var Bet\SelectProfileCollection
     */
    private $selectProfileCollection;

    /**
     * @param Bet\SelectProfileCollection $selectProfileCollection
     */
    public function __construct(
        Bet\SelectProfileCollection $selectProfileCollection
    ) {
        $this->selectProfileCollection = $selectProfileCollection;
    }

    /**
     * @param string $owner
     * @param int $amount In cents
     */
    public function increment(
        string $owner,
        int $amount
    ) {
        $this->manage($owner, $amount);
    }

    /**
     * @param string $owner
     * @param int $amount In cents
     *
     * @throws InsufficientBalanceException
     */
    public function decrement(
        string $owner,
        int $amount
    ) {
        /** @var Bet\Profile $profile */
        $profile = $this->selectProfileCollection->select()->findOne(['_id' => $owner]);

        if ($profile->getBalance() < $amount) {
            throw new InsufficientBalanceException();
        }

        $this->manage($owner, - $amount);
    }

    /**
     * @param string $owner
     * @param int $amount   Can be positive or negative
     */
    private function manage(
        string $owner,
        int $amount
    ) {
        /** @var UpdateResult $result */
        $result = $this->selectProfileCollection->select()->updateOne(
            [
                '_id' => $owner
            ], [
                '$inc' => ['balance' => $amount]
            ]
        );

        if ($result->getMatchedCount() == 0) {
            throw new \LogicException();
        }
    }
}