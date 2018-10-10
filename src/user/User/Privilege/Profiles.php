<?php

namespace Reto\User\Privilege;

use Yosmy\Privilege;

class Profiles extends Privilege\Profiles
{
    /**
     * @param \Traversable $cursor
     */
    public function __construct(
        \Traversable $cursor
    ) {
        parent::__construct(
            $cursor,
            Profile::class
        );
    }
}
