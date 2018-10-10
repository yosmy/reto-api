<?php

namespace Reto\User\Bet;

/**
 * @di\service()
 */
class PickProfile
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
     * @return Profile
     *
     * @throws NonexistentProfileException
     */
    public function pick(
        string $owner
    ) {
        /** @var Profile $owner */
        $owner = $this->selectProfileCollection
            ->select()
            ->findOne(['_id' => $owner]);

        if ($owner === null) {
            throw new NonexistentProfileException();
        }

        return $owner;
    }
}
