<?php

/*
 * This file is part of the Phony package.
 *
 * Copyright © 2016 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Eloquent\Phony\Stub\Answer\Builder;

use Eloquent\Phony\Invocation\Invoker;
use Eloquent\Phony\Mock\Handle\InstanceHandle;
use Eloquent\Phony\Stub\Answer\CallRequest;

/**
 * A detail class for generator answer builders without support for return
 * values.
 *
 * @codeCoverageIgnore
 */
abstract class GeneratorAnswerBuilderDetail
{
    /**
     * Get the answer.
     *
     * @param array<tuple<boolean,mixed,boolean,mixed,array<CallRequest>>> &$iterations      The iteration details.
     * @param array<CallRequest>                                           &$requests        The call requests
     * @param Exception|Error|null                                         &$exception       The exception to throw.
     * @param mixed                                                        &$returnValue     The return value.
     * @param integer|null                                                 &$returnsArgument The index of the argument to return.
     * @param boolean                                                      &$returnsSelf     True if the self value should be returned.
     * @param Invoker                                                      $invoker          The invoker to use.
     *
     * @return callable The answer.
     */
    public static function answer(
        array &$iterations,
        array &$requests,
        &$exception,
        &$returnValue,
        &$returnsArgument,
        &$returnsSelf,
        Invoker $invoker
    ) {
        // @codeCoverageIgnoreStart
        return function ($self, $arguments) use (
            &$iterations,
            &$requests,
            &$exception,
            $invoker
        ) {
            // @codeCoverageIgnoreEnd
            foreach ($iterations as $iteration) {
                foreach ($iteration->requests as $request) {
                    $invoker->callWith(
                        $request->callback(),
                        $request->finalArguments($self, $arguments)
                    );
                }

                if ($iteration instanceof GeneratorYieldFromIteration) {
                    foreach ($iteration->values as $key => $value) {
                        if (
                            $key instanceof InstanceHandle &&
                            $key->isAdaptable()
                        ) {
                            $key = $key->mock();
                        }

                        if (
                            $value instanceof InstanceHandle &&
                            $value->isAdaptable()
                        ) {
                            $value = $value->mock();
                        }

                        yield $key => $value;
                    }
                } else {
                    if ($iteration->hasKey) {
                        yield $iteration->key => $iteration->value;
                    } elseif ($iteration->hasValue) {
                        yield $iteration->value;
                    } else {
                        yield;
                    }
                }
            }

            foreach ($requests as $request) {
                $invoker->callWith(
                    $request->callback(),
                    $request->finalArguments($self, $arguments)
                );
            }

            if ($exception) {
                throw $exception;
            }
        };
    }

    private $invoker;
    private $requests;
    private $iterations;
}
