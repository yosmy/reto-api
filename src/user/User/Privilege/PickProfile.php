<?php

namespace Reto\User\Privilege;

use Yosmy\Privilege;

/**
 * @di\service()
 */
class PickProfile
{
    /**
     * @var Privilege\PickProfile
     */
    private $pickProfile;

    /**
     * @param Privilege\PickProfile $pickProfile
     */
    public function __construct(Privilege\PickProfile $pickProfile)
    {
        $this->pickProfile = $pickProfile;
    }

    /**
     * @param string $client
     *
     * @return Profile
     */
    public function pick(
        string $client
    ) {
        try {
            $profile = $this->pickProfile->pick($client);
        } catch (Privilege\NonexistentProfileException $e) {
            throw new \LogicException(null, null, $e);
        }

        return new Profile($profile);
    }
}