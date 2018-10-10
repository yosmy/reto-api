<?php

namespace Reto;

/**
 * @di\service()
 */
class CollectResults
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
    )
    {
        $this->selectCollection = $selectCollection;
    }

    /**
     * @http\resolution({method: "POST", path: "/bet/collect-results"})
     * @domain\authorization({roles: ["client"]})
     *
     * @param string $bet
     *
     * @return Results
     */
    public function collect(
        $bet
    ) {
        $cursor = $this->selectCollection->select()->find([
            'bet' => $bet,
        ]);

        return new Results($cursor);
    }
}
