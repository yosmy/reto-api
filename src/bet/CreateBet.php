<?php

namespace Reto;

use MongoDB\BSON\UTCDateTime;
use Respect\Validation\Validator as V;

/**
 * @di\service({private: true})
 */
class CreateBet
{
    /**
     * @var SelectBetCollection
     */
    private $selectBetCollection;

    /**
     * @var User\Bet\Profile\ManageBalance
     */
    private $manageBalance;

    /**
     * @param SelectBetCollection $selectBetCollection
     * @param User\Bet\Profile\ManageBalance $manageBalance
     */
    public function __construct(
        SelectBetCollection $selectBetCollection,
        User\Bet\Profile\ManageBalance $manageBalance
    ) {
        $this->selectBetCollection = $selectBetCollection;
        $this->manageBalance = $manageBalance;
    }

    /**
     * @http\resolution({method: "POST", path: "/create-bet"})
     * @domain\authorization({roles: ["client"]})
     *
     * @param string $client
     * @param string $text
     * @param int $balance         In cents
     * @param int|null $expiration
     *
     * @throws Bet\InvalidTextException
     * @throws Bet\InvalidBalanceException
     * @throws Bet\InvalidExpirationException
     * @throws User\Bet\Profile\InsufficientBalanceException
     */
    public function create(
        $client,
        $text,
        $balance,
        $expiration
    ) {
        if (V::nullType()
            ->validate($text)
        ) {
            throw new Bet\InvalidTextException();
        }

        if (
            V::not(V::floatVal())
                ->validate($balance)
        ) {
            throw new Bet\InvalidBalanceException();
        }

        if (
            V::not(V::optional(V::date()))
                ->validate($expiration)
        ) {
            throw new Bet\InvalidExpirationException();
        }

        try {
            $this->manageBalance->decrement($client, $balance);
        } catch (User\Bet\Profile\InsufficientBalanceException $e) {
            throw $e;
        }

        if ($expiration !== null) {
            $expiration = new UTCDateTime($expiration * 1000);
        }

        $this->selectBetCollection->select()->insertOne([
            '_id' => uniqid(),
            'owner' => $client,
            'text' => $text,
            'balance' => $balance,
            'expiration' => $expiration,
            'challenges' => []
        ]);
    }
}
