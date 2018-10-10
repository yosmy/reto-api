<?php

namespace Reto;

use MongoDB;

/**
 * @di\service()
 */
class AddResult
{
    /**
     * @var SelectResultCollection
     */
    private $selectCollection;

    /**
     * @param SelectResultCollection $selectCollection
     */
    public function __construct(
        SelectResultCollection $selectCollection
    ) {
        $this->selectCollection = $selectCollection;
    }

    /**
     * @http\resolution({method: "POST", path: "/bet/add-result"})
     * @domain\authorization({roles: ["client"]})
     *
     * @param string $bet
     * @param string $client
     * @param bool $won
     */
    public function add(
        string $bet,
        string $client,
        bool $won
    ) {
        /** @var MongoDB\UpdateResult $result */
        $result = $this->selectCollection->select()->insertOne([
            '_id' => uniqid(),
            'bet' => $bet,
            'client' => $client,
            'won' => $won
        ]);

        if ($result->getMatchedCount() === 0) {
            throw new \LogicException();
        }
    }
}
