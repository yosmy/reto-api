<?php

namespace Reto;

use MongoDB\UpdateResult;

/**
 * @di\service()
 */
class UpdateBet
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
     * @http\resolution({method: "POST", path: "/update-bet"})
     * @domain\authorization({roles: ["client"]})
     *
     * @param string $client
     * @param string $id
     * @param string $text
     *
     * @throws Bet\ChallengedException If the bet already has challenge
     */
    public function update(
        string $client,
        string $id,
        string $text
    ) {
        /** @var Bet $bet */
        $bet = $this->selectCollection->select()->findOne([
            '_id' => $bet
        ]);

        if ($bet->getChallenges() != []) {
            throw new Bet\ChallengedException();
        }

        /** @var UpdateResult $result */
        $result = $this->selectCollection->select()->updateOne(
            [
                '_id' => $id,
                'owner' => $client
            ],
            ['$set' => [
                'text' => $text,
            ]]
        );

        if ($result->getMatchedCount() === 0) {
            throw new \LogicException();
        }
    }
}
