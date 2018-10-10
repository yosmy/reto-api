<?php

namespace Reto\Http;

use Reto\User\Privilege;
use Symsonte\Authorization\Role\Collector as BaseCollector;

/**
 * @di\service({
 *     private: true
 * })
 */
class RoleCollector implements BaseCollector
{
    /**
     * @var Privilege\PickProfile
     */
    private $pickPrivilegeProfile;

    /**
     * @param Privilege\PickProfile $pickPrivilegeProfile
     */
    function __construct(
        Privilege\PickProfile $pickPrivilegeProfile
    ) {
        $this->pickPrivilegeProfile = $pickPrivilegeProfile;
    }

    /**
     * {@inheritdoc}
     */
    public function collect($user)
    {
        return $this->pickPrivilegeProfile
            ->pick($user)
            ->getRoles();
    }
}
