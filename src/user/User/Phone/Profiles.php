<?php

namespace Reto\User\Phone;

use Yosmy\Phone;

class Profiles extends Phone\Profiles
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
