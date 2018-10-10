<?php

namespace Reto\User\Privilege;

use Yosmy\Privilege;
use \JsonSerializable;

class Profile implements JsonSerializable
{
    /**
     * @var string
     */
    private $owner;

    /**
     * @var array
     */
    private $roles;

    /**
     * @param Privilege\Profile $profile
     */
    public function __construct(Privilege\Profile $profile)
    {
        $this->owner = $profile->getOwner();
        $this->roles = $profile->getRoles();
    }

    /**
     * @return string
     */
    public function getOwner(): string
    {
        return $this->owner;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'owner' => $this->getOwner(),
            'roles' => $this->getRoles(),
        ];
    }
}
