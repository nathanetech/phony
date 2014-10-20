<?php

/*
 * This file is part of the Phony package.
 *
 * Copyright © 2014 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Eloquent\Phony\Mock\Proxy\Verification;

use Eloquent\Phony\Mock\Exception\MockExceptionInterface;
use Eloquent\Phony\Mock\Exception\UndefinedMethodStubException;
use Eloquent\Phony\Mock\Proxy\AbstractProxy;
use Eloquent\Phony\Mock\Proxy\Exception\UndefinedMethodException;
use Exception;

/**
 * An abstract base class for implementing verification proxies.
 *
 * @internal
 */
abstract class AbstractVerificationProxy extends AbstractProxy implements
    VerificationProxyInterface
{
    /**
     * Throws an exception unless the specified method was called with the
     * supplied arguments.
     *
     * @param string               $name      The method name.
     * @param array<integer,mixed> $arguments The arguments.
     *
     * @return VerificationProxyInterface This proxy.
     * @throws MockExceptionInterface     If the stub does not exist.
     * @throws Exception                  If the assertion fails.
     */
    public function __call($name, array $arguments)
    {
        try {
            $stub = $this->stub($name);
        } catch (UndefinedMethodStubException $e) {
            throw new UndefinedMethodException(get_called_class(), $name, $e);
        }

        return call_user_func_array(array($stub, 'calledWith'), $arguments);
    }
}