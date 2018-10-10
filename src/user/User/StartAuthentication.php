<?php

namespace Reto\User;

use Yosmy\User;

/**
 * @di\service()
 */
class StartAuthentication
{
    /**
     * @var string
     */
    private $env;

    /**
     * @var User\Dev\StartAuthentication
     */
    private $devStartAuthentication;

    /**
     * @var User\StartAuthentication
     */
    private $startAuthentication;

    /**
     * @di\arguments({
     *     env: "%env%"
     * })
     *
     * @param string $env
     * @param User\Dev\StartAuthentication $devStartAuthentication
     * @param User\StartAuthentication $startAuthentication
     */
    public function __construct(
        string $env,
        User\Dev\StartAuthentication $devStartAuthentication,
        User\StartAuthentication $startAuthentication
    ) {
        $this->env = $env;
        $this->devStartAuthentication = $devStartAuthentication;
        $this->startAuthentication = $startAuthentication;
    }

    /**
     * @http\resolution({method: "POST", path: "/user/start-authentication"})
     *
     * @param string $number
     *
     * @throws Authentication\InvalidNumberException
     */
    public function start(
        string $number
    ) {
        if ($this->env == 'dev') {
            try {
                $this->devStartAuthentication->start($number);
            } catch (User\Authentication\InvalidNumberException $e) {
                throw new Authentication\InvalidNumberException();
            }
        } else {
            try {
                $this->startAuthentication->start($number);
            } catch (User\Authentication\InvalidNumberException $e) {
                throw new Authentication\InvalidNumberException();
            }
        }
    }
}