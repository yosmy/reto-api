<?php

namespace Reto\User\Phone;

use Yosmy\Phone;

/**
 * @di\service()
 */
class CollectProfiles
{
    /**
     * @var Phone\CollectProfiles
     */
    private $collectProfiles;

    /**
     * @param Phone\CollectProfiles $collectProfiles
     */
    public function __construct(Phone\CollectProfiles $collectProfiles)
    {
        $this->collectProfiles = $collectProfiles;
    }

    /**
     * @http\resolution({method: "POST", path: "/user/phone/collect-profiles"})
     * @domain\authorization({roles: ["operator"]})
     *
     * @param string[] $owners
     *
     * @return Profiles
     */
    public function collect(
        array $owners
    ) {
        $countries = new Profiles(
            $this->collectProfiles->collect($owners)->getIterator()
        );

        return $countries;
    }
}