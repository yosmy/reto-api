<?php

namespace Reto;

/**
 * @di\service()
 */
class ChallengeBet
{
    /**
     * @var SelectBetCollection
     */
    private $selectCollection;

    /**
     * @param SelectBetCollection $selectCollection
     */
    public function __construct(
        SelectBetCollection $selectCollection
    ) {
        $this->selectCollection = $selectCollection;
    }

    /**
     * @http\resolution({method: "POST", path: "/challenge-bet"})
     * @domain\authorization({roles: ["client"]})
     *
     * @param string $client
     * @param string $id
     * @param int $amount    In cents
     *
     * @throws ExpiredBetException
     * @throws Bet\InsufficientBalanceException
     */
    public function challenge(
        string $client,
        string $id,
        int $amount
    ) {
        /** @var Bet $bet */
        $bet = $this->selectCollection->select()->findOne([
            '_id' => $id
        ]);

        if ($bet->getExpiration() < time()) {
            throw new ExpiredBetException();
        }

        // Does the bet has sufficient balance to cover the challenge?
        if ($bet->getBalance() < $amount) {
            throw new Bet\InsufficientBalanceException();
        }

        $this->selectCollection->select()->updateOne(
            [
                '_id' => $bet,
            ],
            [
                '$inc' => [
                    'balance' => - $amount
                ],
                '$push' => [
                    'challenges' => [
                        'owner' => $client,
                        'amount' => $amount
                    ]
                ]
            ]
        );
    }
}
