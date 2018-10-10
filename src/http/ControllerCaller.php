<?php

namespace Reto\Http;

use Yosmy\ReportError;
use Symsonte\Http\Server\ControllerCaller as BaseControllerCaller;
use Symsonte\Http\Server\OrdinaryResponse;

/**
 * @di\service({
 *     private: true
 * })
 */
class ControllerCaller implements BaseControllerCaller
{
    /**
     * @var ReportError
     */
    private $reportError;

    /**
     * @param ReportError $reportError
     */
    public function __construct(ReportError $reportError)
    {
        $this->reportError = $reportError;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Throwable
     */
    public function call($controller, $method, $parameters)
    {
        $this->reportError->register();

        try {
            $result = call_user_func_array([$controller, $method], $parameters);

            if ($result instanceof OrdinaryResponse) {
                return $result;
            }

            $response = [
                'code' => 'success',
                'payload' => $result
            ];
        } catch (\Exception $e) {
            $payload = null;

            if ($e instanceof \JsonSerializable) {
                $payload = $e->jsonSerialize();
            }

            if (strpos(get_class($e), 'Reto') === 0) {
                $code = $this->generateKey(
                    str_replace(
                        'Reto\\',
                        '',
                        get_class($e)
                    )
                );

                $response = [
                    'code' => $code,
                    'payload' => $payload
                ];
            } else {
                $this->reportError->report($e);

                $response = [
                    'code' => 'unexpected_exception',
                ];
            }
        } catch (\Throwable $e) {
            $this->reportError->report($e);

            $response = [
                'code' => 'unexpected_exception',
            ];
        }

        return $response;
    }

    /**
     * @param string $class
     *
     * @return string
     */
    private function generateKey($class)
    {
        return strtolower(
            strtr(
                preg_replace(
                    '/(?<=[a-zA-Z0-9])[A-Z]/',
                    '-\\0',
                    $class
                ),
                '\\',
                '.'
            )
        );
    }
}
