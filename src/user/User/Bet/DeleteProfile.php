<?php

namespace Reto\User\Bet;

use MongoDB\DeleteResult;

/**
 * @di\service()
 */
class DeleteProfile
{
    /**
     * @var SelectProfileCollection
     */
    private $selectProfileCollection;

    /**
     * @param SelectProfileCollection $selectProfileCollection
     */
    public function __construct(SelectProfileCollection $selectProfileCollection)
    {
        $this->selectProfileCollection = $selectProfileCollection;
    }

    /**
     * @param string $owner
     *
     * @throws NonexistentProfileException
     */
    public function delete(
        string $owner
    ) {
        /** @var DeleteResult $deleteResult */
        $deleteResult = $this->selectProfileCollection
            ->select()
            ->deleteOne(
                [
                    '_id' => $owner
                ]
            );

        if ($deleteResult->getDeletedCount() == 0) {
            throw new NonexistentProfileException();
        }
    }
}
