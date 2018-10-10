<?php

namespace Reto;

use MongoDB\Model\BSONDocument;

class Result extends BSONDocument
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
    public function getBet(): string
    {
        return $this->offsetGet('bet');
    }

    /**
     * @return string
     */
    public function getOwner(): string
    {
        return $this->offsetGet('owner');
    }

    /**
     * Returns whether the bet won or not.
     *
     * @return bool
     */
    public function didWon(): bool
    {
        return $this->offsetGet('won');
    }

    /**
     * {@inheritdoc}
     */
    public function bsonUnserialize(array $data)
    {
        $data['id'] = $data['_id'];
        unset($data['_id']);

        parent::bsonUnserialize($data);
    }
}
