<?php

namespace Reto\User\Push;

use Yosmy\Push;

/**
 * @di\service()
 */
class AssignProfile
{
    /**
     * @var Push\AddProfile
     */
    private $addProfile;

    /**
     * @var Push\UpdateProfile
     */
    private $updateProfile;

    /**
     * @param Push\AddProfile $addProfile
     * @param Push\UpdateProfile $updateProfile
     */
    public function __construct(
        Push\AddProfile $addProfile,
        Push\UpdateProfile $updateProfile
    ) {
        $this->addProfile = $addProfile;
        $this->updateProfile = $updateProfile;
    }

    /**
     * @http\resolution({method: "POST", path: "/user/push/assign-profile"})
     * @domain\authorization({roles: ["client"]})
     *
     * @param $client
     * @param $push
     */
    public function assign($client, $push)
    {
        try {
            $this->updateProfile->update($client, $push);
        } catch (Push\NonexistentProfileException $e) {
            try {
                $this->addProfile->add($client, $push);
            } catch (Push\ExistentProfileException $e) {
                throw new \LogicException(null, null, $e);
            }
        }
    }
}
