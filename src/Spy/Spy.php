<?php

/*
 * This file is part of the Phony package.
 *
 * Copyright © 2016 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Eloquent\Phony\Spy;

use Eloquent\Phony\Call\Call;
use Eloquent\Phony\Event\EventCollection;
use Eloquent\Phony\Invocation\WrappedInvocable;

/**
 * The interface implemented by spies.
 *
 * @api
 */
interface Spy extends WrappedInvocable, EventCollection
{
    /**
     * Turn on or off the use of generator spies.
     *
     * @api
     *
     * @param boolean $useGeneratorSpies True to use generator spies.
     *
     * @return $this This spy.
     */
    public function setUseGeneratorSpies($useGeneratorSpies);

    /**
     * Returns true if this spy uses generator spies.
     *
     * @api
     *
     * @return boolean True if this spy uses generator spies.
     */
    public function useGeneratorSpies();

    /**
     * Turn on or off the use of traversable spies.
     *
     * @api
     *
     * @param boolean $useTraversableSpies True to use traversable spies.
     *
     * @return $this This spy.
     */
    public function setUseTraversableSpies($useTraversableSpies);

    /**
     * Returns true if this spy uses traversable spies.
     *
     * @api
     *
     * @return boolean True if this spy uses traversable spies.
     */
    public function useTraversableSpies();

    /**
     * Stop recording calls.
     *
     * @api
     *
     * @return $this This spy.
     */
    public function stopRecording();

    /**
     * Start recording calls.
     *
     * @api
     *
     * @return $this This spy.
     */
    public function startRecording();

    /**
     * Set the calls.
     *
     * @param array<Call> $calls The calls.
     */
    public function setCalls(array $calls);

    /**
     * Add a call.
     *
     * @param Call $call The call.
     */
    public function addCall(Call $call);
}
