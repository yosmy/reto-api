<?php

namespace Reto\User\Phone;

use Yosmy\Phone;

/**
 * @di\service()
 */
class PickProfile
{
    /**
     * @var Phone\PickProfile
     */
    private $pickProfile;

    /**
     * @param Phone\PickProfile $pickProfile
     */
    public function __construct(Phone\PickProfile $pickProfile)
    {
        $this->pickProfile = $pickProfile;
    }

    /**
     * @http\resolution({method: "POST", path: "/user/phone/pick-profile"})
     * @domain\authorization({roles: ["operator"]})
     *
     * @param string $client
     *
     * @return Profile
     */
    public function pick(
        string $client
    ) {
        try {
            $profile = $this->pickProfile->pick($client);
        } catch (Phone\NonexistentProfileException $e) {
            throw new \LogicException(null, null, $e);
        }

        return new Profile($profile);
    }
}