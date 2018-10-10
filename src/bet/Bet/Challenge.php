<?php

namespace Reto\Bet;

class Challenge implements \JsonSerializable
{
    /**
     * @var string
     */
    private $owner;

    /**
     * @var int
     */
    private $amount;

    /**
     * @param string $owner
     * @param int $amount
     */
    public function __construct(string $owner, int $amount)
    {
        $this->owner = $owner;
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getOwner(): string
    {
        return $this->owner;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'owner' => $this->getOwner(),
            'amount' => $this->getAmount(),
        ];
    }
}