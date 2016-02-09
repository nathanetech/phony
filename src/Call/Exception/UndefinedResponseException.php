<?php

/*
 * This file is part of the Phony package.
 *
 * Copyright © 2016 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Eloquent\Phony\Call\Exception;

use Exception;

/**
 * The call has not yet produced a response of the requested type.
 *
 * @api
 */
final class UndefinedResponseException extends Exception
{
    /**
     * Construct a new undefined return value exception.
     *
     * @param string         $message The message.
     * @param Exception|null $cause   The cause, if available.
     */
    public function __construct($message, Exception $cause = null)
    {
        parent::__construct($message, 0, $cause);
    }
}