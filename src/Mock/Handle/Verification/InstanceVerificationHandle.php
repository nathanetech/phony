<?php

/*
 * This file is part of the Phony package.
 *
 * Copyright © 2016 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Eloquent\Phony\Mock\Handle\Verification;

use Eloquent\Phony\Mock\Exception\MockException;
use Eloquent\Phony\Mock\Handle\AbstractInstanceHandle;
use Eloquent\Phony\Mock\Handle\InstanceHandle;
use Exception;

/**
 * A handle for verifying a mock.
 *
 * @api
 */
class InstanceVerificationHandle extends AbstractInstanceHandle implements
    InstanceHandle,
    VerificationHandle
{
    /**
     * Throws an exception unless the specified method was called with the
     * supplied arguments.
     *
     * @param string $name      The method name.
     * @param array  $arguments The arguments.
     *
     * @return $this         This handle.
     * @throws MockException If the stub does not exist.
     * @throws Exception     If the assertion fails, and the assertion recorder throws exceptions.
     */
    public function __call($name, array $arguments)
    {
        $key = strtolower($name);

        if (isset($this->state->stubs->$key)) {
            $stub = $this->state->stubs->$key;
        } else {
            $stub = $this->state->stubs->$key = $this->createStub($name);
        }

        call_user_func_array(array($stub, 'calledWith'), $arguments);

        return $this;
    }
}