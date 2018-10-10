<?php

namespace Reto;

/**
 * @di\service()
 */
class CollectBets
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
     * @http\resolution({method: "POST", path: "/collect-bets"})
     * @domain\authorization({roles: ["client"]})
     *
     * @param string|null $client
     *
     * @return Bets
     */
    public function collect(
        ?string $client = null
    ) {
        $criteria = [];

        if ($client !== null) {
            $criteria['owner'] = $client;
        }

        $cursor = $this->selectCollection->select()->find(
            $criteria,
            [
                'sort' => [
                    'expiration' => -1
                ]
            ]
        );

        return new Bets($cursor);
    }
}
