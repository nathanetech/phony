<?php

/*
 * This file is part of the Phony package.
 *
 * Copyright © 2014 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Eloquent\Phony\Phpunit;

use Eloquent\Phony\Call\Event\CallEventCollectionInterface;
use Eloquent\Phony\Integration\Phpunit\PhpunitFacadeDriver;
use Eloquent\Phony\Matcher\MatcherInterface;
use Eloquent\Phony\Mock\Exception\MockExceptionInterface;
use Eloquent\Phony\Mock\MockInterface;
use Eloquent\Phony\Mock\Proxy\InstanceMockProxyInterface;
use Eloquent\Phony\Mock\Proxy\StaticMockProxyInterface;
use Eloquent\Phony\Spy\SpyVerifierInterface;
use Eloquent\Phony\Stub\StubVerifierInterface;
use Exception;
use ReflectionClass;

/**
 * Create a new mock builder.
 *
 * @param array<string|object>|string|object|null $types      The types to mock.
 * @param array|object|null                       $definition The definition.
 * @param string|null                             $className  The class name.
 *
 * @return MockBuilderInterface The mock builder.
 */
function mock(
    $types = null,
    $definition = null,
    $className = null
) {
    return PhpunitFacadeDriver::instance()->mockBuilderFactory()
        ->create($types, $definition, $className);
}

/**
 * Create a new mock proxy.
 *
 * @param MockInterface $mock The mock.
 *
 * @return InstanceMockProxyInterface The mock proxy.
 */
function on(MockInterface $mock)
{
    return PhpunitFacadeDriver::instance()->mockProxyFactory()->create($mock);
}

/**
 * Create a new static mock proxy.
 *
 * @param ReflectionClass|object|string $class The class.
 *
 * @return StaticMockProxyInterface The mock proxy.
 * @throws MockExceptionInterface If the supplied class name is not a mock class.
 */
function onStatic($class)
{
    return PhpunitFacadeDriver::instance()->mockProxyFactory()
        ->createStatic($class);
}

/**
 * Create a new spy verifier for the supplied callback.
 *
 * @param callable|null $callback The callback, or null to create an unbound spy verifier.
 * @param boolean|null  $useTraversableSpies True if traversable spies should be used.
 * @param boolean|null  $useGeneratorSpies   True if generator spies should be used.
 *
 * @return SpyVerifierInterface The newly created spy verifier.
 */
function spy(
    $callback = null,
    $useTraversableSpies = null,
    $useGeneratorSpies = null
) {
    return PhpunitFacadeDriver::instance()->spyVerifierFactory()
        ->createFromCallback(
            $callback,
            $useTraversableSpies,
            $useGeneratorSpies
        );
}

/**
 * Create a new stub verifier for the supplied callback.
 *
 * @param callable|null $callback  The callback, or null to create an unbound stub verifier.
 * @param object|null   $thisValue The $this value.
 * @param boolean|null  $useTraversableSpies True if traversable spies should be used.
 * @param boolean|null  $useGeneratorSpies   True if generator spies should be used.
 *
 * @return StubVerifierInterface The newly created stub verifier.
 */
function stub(
    $callback = null,
    $thisValue = null,
    $useTraversableSpies = null,
    $useGeneratorSpies = null
) {
    return PhpunitFacadeDriver::instance()->stubVerifierFactory()
        ->createFromCallback(
            $callback,
            $thisValue,
            $useTraversableSpies,
            $useGeneratorSpies
        );
}

/**
 * Checks if the supplied events happened in chronological order.
 *
 * @param CallEventCollectionInterface $events,... The events.
 *
 * @return CallEventCollectionInterface|null The result.
 */
function checkInOrder()
{
    return PhpunitFacadeDriver::instance()->eventOrderVerifier()
        ->checkInOrderSequence(func_get_args());
}

/**
 * Throws an exception unless the supplied events happened in chronological
 * order.
 *
 * @param CallEventCollectionInterface $events,... The events.
 *
 * @return CallEventCollectionInterface The result.
 * @throws Exception If the assertion fails.
 */
function inOrder()
{
    return PhpunitFacadeDriver::instance()->eventOrderVerifier()
        ->inOrderSequence(func_get_args());
}

/**
 * Checks if the supplied event sequence happened in chronological order.
 *
 * @param mixed<CallEventCollectionInterface> $events The event sequence.
 *
 * @return CallEventCollectionInterface|null The result.
 */
function checkInOrderSequence($events)
{
    return PhpunitFacadeDriver::instance()->eventOrderVerifier()
        ->checkInOrderSequence($events);
}

/**
 * Throws an exception unless the supplied event sequence happened in
 * chronological order.
 *
 * @param mixed<CallEventCollectionInterface> $events The event sequence.
 *
 * @return CallEventCollectionInterface The result.
 * @throws Exception If the assertion fails.
 */
function inOrderSequence($events)
{
    return PhpunitFacadeDriver::instance()->eventOrderVerifier()
        ->inOrderSequence($events);
}

/**
 * Create a new matcher that matches anything.
 *
 * @return MatcherInterface The newly created matcher.
 */
function any()
{
    return PhpunitFacadeDriver::instance()->matcherFactory()->any();
}

/**
 * Create a new equal to matcher.
 *
 * @param mixed $value The value to check.
 *
 * @return MatcherInterface The newly created matcher.
 */
function equalTo($value)
{
    return PhpunitFacadeDriver::instance()->matcherFactory()->equalTo($value);
}

/**
 * Create a new matcher that matches multiple arguments.
 *
 * @param mixed        $value            The value to check for each argument.
 * @param integer|null $minimumArguments The minimum number of arguments.
 * @param integer|null $maximumArguments The maximum number of arguments.
 *
 * @return WildcardMatcherInterface The newly created wildcard matcher.
 */
function wildcard(
    $value = null,
    $minimumArguments = null,
    $maximumArguments = null
) {
    return PhpunitFacadeDriver::instance()->matcherFactory()
        ->wildcard($value, $minimumArguments, $maximumArguments);
}
