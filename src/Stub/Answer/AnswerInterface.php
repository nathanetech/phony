<?php

/*
 * This file is part of the Phony package.
 *
 * Copyright © 2015 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Eloquent\Phony\Stub\Answer;

/**
 * The interface implemented by answers.
 */
interface AnswerInterface
{
    /**
     * Get the primary request.
     *
     * @return CallRequestInterface|null The primary request, or null if none has been set.
     */
    public function primaryRequest();

    /**
     * Get the secondary requests.
     *
     * @return array<CallRequestInterface> The secondary requests.
     */
    public function secondaryRequests();
}
