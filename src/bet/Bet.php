<?php

namespace Reto;

use MongoDB\BSON\UTCDateTime;
use MongoDB\Model\BSONDocument;

class Bet extends BSONDocument
{
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->offsetGet('id');
    }

    /**
     * @return string
     */
    public function getOwner(): string
    {
        return $this->offsetGet('owner');
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->offsetGet('text');
    }

    /**
     * Balance available to accept challenges.
     *
     * @return int
     */
    public function getBalance(): int
    {
        return $this->offsetGet('balance');
    }

    /**
     * @return array
     */
    public function getChallenges(): array
    {
        return $this->offsetGet('array');
    }

    /**
     * Returns the expiration date.
     * After this date, if there is still no opponent, the bet is no longer valid.
     *
     * @return int
     */
    public function getExpiration(): int
    {
        return $this->offsetGet('expiration');
    }

    /**
     * {@inheritdoc}
     */
    public function bsonUnserialize(array $data)
    {
        $data['id'] = $data['_id'];
        unset($data['_id']);

        if ($data['expiration'] != null) {
            /** @var UTCDateTime $expiration */
            $expiration = $data['expiration'];
            $data['expiration'] = $expiration->toDateTime()->getTimestamp();
        }

        $challenges = [];
        foreach ($data['challenges'] as $challenge) {
            $challenges[] = new Bet\Challenge($challenge['owner'], $challenge['amount']);
        }
        $data['challenges'] = $challenges;

        parent::bsonUnserialize($data);
    }
}
