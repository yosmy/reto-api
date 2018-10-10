<?php

namespace Reto\User\Bet;

use MongoDB\Model\BSONDocument;
use Yosmy\Ownership;

class Profile extends BSONDocument implements Ownership
{
    /**
     * @return string
     */
    public function getOwner(): string
    {
        return $this->offsetGet('owner');
    }

    /**
     * Balance in cents.
     *
     * @return int
     */
    public function getBalance(): int
    {
        return $this->offsetGet('balance');
    }

    /**
     * {@inheritdoc}
     */
    public function bsonUnserialize(array $data)
    {
        $data['owner'] = $data['_id'];
        unset($data['_id']);

        parent::bsonUnserialize($data);
    }
}
