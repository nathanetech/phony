<?php

/*
 * This file is part of the Phony package.
 *
 * Copyright © 2014 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Eloquent\Phony\Spy;

use Eloquent\Phony\Call\Argument\Arguments;
use Eloquent\Phony\Call\Argument\ArgumentsInterface;
use Eloquent\Phony\Call\Call;
use Eloquent\Phony\Call\CallInterface;
use Eloquent\Phony\Call\Factory\CallFactory;
use Eloquent\Phony\Call\Factory\CallFactoryInterface;
use Eloquent\Phony\Invocation\AbstractWrappedInvocable;
use Eloquent\Phony\Spy\Factory\TraversableSpyFactory;
use Eloquent\Phony\Spy\Factory\TraversableSpyFactoryInterface;
use Exception;

/**
 * Spies on a function or method.
 *
 * @internal
 */
class Spy extends AbstractWrappedInvocable implements SpyInterface
{
    /**
     * Construct a new spy.
     *
     * @param callable|null                       $callback              The callback, or null to create an unbound spy.
     * @param boolean|null                        $useTraversableSpies   True if traversable spies should be used.
     * @param boolean|null                        $useGeneratorSpies     True if generator spies should be used.
     * @param string|null                         $label                 The label.
     * @param CallFactoryInterface|null           $callFactory           The call factory to use.
     * @param TraversableSpyFactoryInterface|null $traversableSpyFactory The traversable spy factory to use.
     */
    public function __construct(
        $callback = null,
        $useTraversableSpies = null,
        $useGeneratorSpies = null,
        $label = null,
        CallFactoryInterface $callFactory = null,
        TraversableSpyFactoryInterface $traversableSpyFactory = null
    ) {
        if (null === $useTraversableSpies) {
            $useTraversableSpies = false;
        }
        if (null === $useGeneratorSpies) {
            $useGeneratorSpies = !defined('HHVM_VERSION');
        }
        if (null === $callFactory) {
            $callFactory = CallFactory::instance();
        }
        if (null === $traversableSpyFactory) {
            $traversableSpyFactory = TraversableSpyFactory::instance();
        }

        parent::__construct($callback, $label);

        $this->useTraversableSpies = $useTraversableSpies;
        $this->useGeneratorSpies = $useGeneratorSpies;
        $this->callFactory = $callFactory;
        $this->traversableSpyFactory = $traversableSpyFactory;
        $this->calls = array();
    }

    /**
     * Turn on or off the use of traversable spies.
     *
     * @param boolean $useTraversableSpies True to use traversable spies.
     */
    public function setUseTraversableSpies($useTraversableSpies)
    {
        $this->useTraversableSpies = $useTraversableSpies;
    }

    /**
     * Returns true if this spy uses traversable spies.
     *
     * @return boolean True if this spy uses traversable spies.
     */
    public function useTraversableSpies()
    {
        return $this->useTraversableSpies;
    }

    /**
     * Turn on or off the use of generator spies.
     *
     * @param boolean $useGeneratorSpies True to use generator spies.
     */
    public function setUseGeneratorSpies($useGeneratorSpies)
    {
        $this->useGeneratorSpies = $useGeneratorSpies;
    }

    /**
     * Returns true if this spy uses generator spies.
     *
     * @return boolean True if this spy uses generator spies.
     */
    public function useGeneratorSpies()
    {
        return $this->useGeneratorSpies;
    }

    /**
     * Get the call factory.
     *
     * @return CallFactoryInterface The call factory.
     */
    public function callFactory()
    {
        return $this->callFactory;
    }

    /**
     * Get the traversable spy factory.
     *
     * @return TraversableSpyFactoryInterface The traversable spy factory.
     */
    public function traversableSpyFactory()
    {
        return $this->traversableSpyFactory;
    }

    /**
     * Set the calls.
     *
     * @param array<CallInterface> $calls The calls.
     */
    public function setCalls(array $calls)
    {
        $this->calls = $calls;
    }

    /**
     * Add a call.
     *
     * @param CallInterface $call The call.
     */
    public function addCall(CallInterface $call)
    {
        $this->calls[] = $call;
    }

    /**
     * Get the recorded calls.
     *
     * @return array<CallInterface> The recorded calls.
     */
    public function recordedCalls()
    {
        return $this->calls;
    }

    /**
     * Invoke this object.
     *
     * This method supports reference parameters.
     *
     * @param ArgumentsInterface|array<integer,mixed>|null The arguments.
     *
     * @return mixed     The result of invocation.
     * @throws Exception If an error occurs.
     */
    public function invokeWith($arguments = null)
    {
        $call = $this->callFactory
            ->record($this->callback, Arguments::adapt($arguments), $this);
        $exception = $call->exception();

        if ($exception) {
            throw $exception;
        }

        $returnValue = $call->returnValue();

        if (
            $this->useTraversableSpies &&
            $this->traversableSpyFactory->isTraversable($returnValue)
        ) {
            return $this->traversableSpyFactory
                ->create($call, $returnValue, $this->useGeneratorSpies);
        }

        return $returnValue;
    }

    private $useTraversableSpies;
    private $useGeneratorSpies;
    private $callFactory;
    private $traversableSpyFactory;
    private $calls;
}
