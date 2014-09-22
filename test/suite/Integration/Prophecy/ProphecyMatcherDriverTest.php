<?php

/*
 * This file is part of the Phony package.
 *
 * Copyright © 2014 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Eloquent\Phony\Integration\Prophecy;

use PHPUnit_Framework_TestCase;
use Prophecy\Argument\Token\IdenticalValueToken;

class ProphecyMatcherDriverTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->subject = new ProphecyMatcherDriver;
    }

    public function testAdapt()
    {
        $object = (object) array();
        $matcher = new IdenticalValueToken('value');
        $expected = new ProphecyMatcher($matcher);

        $this->assertTrue($this->subject->adapt($matcher));
        $this->assertEquals($expected, $matcher);
        $this->assertFalse($this->subject->adapt($object));
    }
}