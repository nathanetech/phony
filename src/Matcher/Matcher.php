<?php

/*
 * This file is part of the Phony package.
 *
 * Copyright © 2016 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Eloquent\Phony\Matcher;

/**
 * The interface implemented by matchers.
 *
 * @api
 */
interface Matcher
{
    /**
     * Returns `true` if `$value` matches this matcher's criteria.
     *
     * @api
     *
     * @param mixed $value The value to check.
     *
     * @return boolean True if the value matches.
     */
    public function matches($value);

    /**
     * Describe this matcher.
     *
     * @api
     *
     * @return string The description.
     */
    public function describe();

    /**
     * Describe this matcher.
     *
     * @api
     *
     * @return string The description.
     */
    public function __toString();
}