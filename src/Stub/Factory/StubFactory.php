<?php

/*
 * This file is part of the Phony package.
 *
 * Copyright © 2016 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Eloquent\Phony\Stub\Factory;

use Eloquent\Phony\Invocation\InvocableInspector;
use Eloquent\Phony\Invocation\Invoker;
use Eloquent\Phony\Matcher\Factory\MatcherFactory;
use Eloquent\Phony\Matcher\Verification\MatcherVerifier;
use Eloquent\Phony\Sequencer\Sequencer;
use Eloquent\Phony\Stub\Answer\Builder\Factory\GeneratorAnswerBuilderFactory;
use Eloquent\Phony\Stub\StubData;

/**
 * Creates stubs.
 */
class StubFactory
{
    /**
     * Get the static instance of this factory.
     *
     * @return StubFactory The static factory.
     */
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self(
                Sequencer::sequence('stub-label'),
                MatcherFactory::instance(),
                MatcherVerifier::instance(),
                Invoker::instance(),
                InvocableInspector::instance(),
                GeneratorAnswerBuilderFactory::instance()
            );
        }

        return self::$instance;
    }

    /**
     * Construct a new stub factory.
     *
     * @param Sequencer                     $labelSequencer                The label sequencer to use.
     * @param MatcherFactory                $matcherFactory                The matcher factory to use.
     * @param MatcherVerifier               $matcherVerifier               The matcher verifier to use.
     * @param Invoker                       $invoker                       The invoker to use.
     * @param InvocableInspector            $invocableInspector            The invocable inspector to use.
     * @param GeneratorAnswerBuilderFactory $generatorAnswerBuilderFactory The generator answer builder factory to use.
     */
    public function __construct(
        Sequencer $labelSequencer,
        MatcherFactory $matcherFactory,
        MatcherVerifier $matcherVerifier,
        Invoker $invoker,
        InvocableInspector $invocableInspector,
        GeneratorAnswerBuilderFactory $generatorAnswerBuilderFactory
    ) {
        $this->labelSequencer = $labelSequencer;
        $this->matcherFactory = $matcherFactory;
        $this->matcherVerifier = $matcherVerifier;
        $this->invoker = $invoker;
        $this->invocableInspector = $invocableInspector;
        $this->generatorAnswerBuilderFactory = $generatorAnswerBuilderFactory;
    }

    /**
     * Create a new stub.
     *
     * @param callable|null $callback              The callback, or null to create an anonymous stub.
     * @param mixed         $self                  The self value.
     * @param callable      $defaultAnswerCallback The callback to use when creating a default answer.
     *
     * @return Stub The newly created stub.
     */
    public function create(
        $callback = null,
        $self = null,
        $defaultAnswerCallback =
            'Eloquent\Phony\Stub\StubData::forwardsAnswerCallback'
    ) {
        return new StubData(
            $callback,
            $self,
            strval($this->labelSequencer->next()),
            $defaultAnswerCallback,
            $this->matcherFactory,
            $this->matcherVerifier,
            $this->invoker,
            $this->invocableInspector,
            $this->generatorAnswerBuilderFactory
        );
    }

    private static $instance;
    private $labelSequencer;
    private $matcherFactory;
    private $matcherVerifier;
    private $invoker;
    private $invocableInspector;
    private $generatorAnswerBuilderFactory;
}
