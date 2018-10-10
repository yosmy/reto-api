<?php

namespace Reto;

/**
 * @di\service()
 */
class WithdrawBet
{
    /**
     * @var SelectBetCollection
     */
    private $selectCollection;

    /**
     * @var User\Bet\Profile\ManageBalance
     */
    private $manageBalance;

    /**
     * @http\resolution({method: "POST", path: "/withdraw-bet"})
     * @domain\authorization({roles: ["client"]})
     *
     * @param string $client
     * @param string $id
     */
    public function withdraw(
        string $client,
        string $id
    ) {
        /** @var Bet $bet */
        $bet = $this->selectCollection->select()->findOne([
            '_id' => $bet
        ]);

        $this->manageBalance->increment($client, $bet->getBalance());

        $this->selectCollection->select()->updateOne(
            [
                '_id' => $id,
                'owner' => $client
            ],
            ['$set' => [
                'balance' => 0,
            ]]
        );
    }
}
