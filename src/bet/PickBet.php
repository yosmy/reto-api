<?php

namespace Reto;

/**
 * @di\service()
 */
class PickBet
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
    )
    {
        $this->selectCollection = $selectCollection;
    }

    /**
     * @http\resolution({method: "POST", path: "/pick-bet"})
     * @domain\authorization({roles: ["client"]})
     *
     * @param string $id
     *
     * @return Bet
     *
     * @throws NonexistentBetException
     */
    public function pick(
        string $id
    ) {
        $criteria = [
            '_id' => $id,
        ];

        /** @var Bet $bet */
        $bet = $this->selectCollection->select()->findOne($criteria);

        if (is_null($bet)) {
            throw new NonexistentBetException();
        }

        return $bet;
    }
}
