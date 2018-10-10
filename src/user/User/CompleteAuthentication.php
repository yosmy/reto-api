<?php

namespace Reto\User;

use Yosmy\User;

/**
 * @di\service()
 */
class CompleteAuthentication
{
    /**
     * @var string
     */
    private $env;

    /**
     * @var User\Dev\CompleteAuthentication
     */
    private $devCompleteAuthentication;

    /**
     * @var User\CompleteAuthentication
     */
    private $completeAuthentication;

    /**
     * @var Bet\AddProfile
     */
    private $addBetProfile;

    /**
     * @di\arguments({
     *     env: "%env%"
     * })
     *
     * @param string $env
     * @param User\Dev\CompleteAuthentication $devCompleteAuthentication
     * @param User\CompleteAuthentication $completeAuthentication
     * @param Bet\AddProfile $addBetProfile
     */
    public function __construct(
        string $env,
        User\Dev\CompleteAuthentication $devCompleteAuthentication,
        User\CompleteAuthentication $completeAuthentication,
        Bet\AddProfile $addBetProfile
    ) {
        $this->env = $env;
        $this->devCompleteAuthentication = $devCompleteAuthentication;
        $this->completeAuthentication = $completeAuthentication;
        $this->addBetProfile = $addBetProfile;
    }

    /**
     * @http\resolution({method: "POST", path: "/user/complete-authentication"})
     *
     * @param string $number
     * @param string $code
     *
     * @return Authentication
     *
     * @throws Authentication\InvalidCodeException
     * @throws Authentication\InvalidNumberException
     */
    public function complete(
        string $number,
        string $code
    ) {
        if ($this->env == 'dev') {
            $authentication = $this->devCompleteAuthentication->complete($number, $code);
        } else {
            try {
                $authentication = $this->completeAuthentication->complete($number, $code);
            } catch (User\Authentication\InvalidCodeException $e) {
                throw new Authentication\InvalidCodeException();
            } catch (User\Authentication\InvalidNumberException $e) {
                throw new Authentication\InvalidNumberException();
            }
        }

        try {
            $this->addBetProfile->add(
                $authentication->getUser(),
                200
            );
        } catch (Bet\ExistentProfileException $e) {
            // The user already have this profile. Ignore exception
        }

        return new Authentication(
            $authentication->getUser(),
            $authentication->getToken(),
            $authentication->getRoles(),
            $authentication->getPhone()
        );
    }
}