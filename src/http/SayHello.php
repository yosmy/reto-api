<?php

namespace Reto\Http;

/**
 * @di\service()
 */
class SayHello
{
    /**
     * @http\resolution({method: "GET", path: "/"})
     */
    public function say()
    {
    }
}
