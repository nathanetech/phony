<?php

/*
 * This file is part of the Phony package.
 *
 * Copyright © 2015 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Eloquent\Phony\Call\Event;

use Eloquent\Phony\Test\TestCallFactory;
use PHPUnit_Framework_TestCase;

class ProducedEventTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->sequenceNumber = 111;
        $this->time = 1.11;
        $this->key = 'x';
        $this->value = 'y';
        $this->subject = new ProducedEvent($this->sequenceNumber, $this->time, $this->key, $this->value);

        $this->callFactory = new TestCallFactory();
    }

    public function testConstructor()
    {
        $this->assertSame($this->sequenceNumber, $this->subject->sequenceNumber());
        $this->assertSame($this->time, $this->subject->time());
        $this->assertSame($this->key, $this->subject->key());
        $this->assertSame($this->value, $this->subject->value());
        $this->assertNull($this->subject->call());
        $this->assertTrue($this->subject->hasEvents());
        $this->assertSame(array($this->subject), $this->subject->events());
        $this->assertSame($this->subject, $this->subject->firstEvent());
        $this->assertSame($this->subject, $this->subject->lastEvent());
        $this->assertSame(1, count($this->subject));
    }

    public function testConstructorWithValueOnly()
    {
        $this->subject = new ProducedEvent($this->sequenceNumber, $this->time, $this->value);

        $this->assertNull($this->subject->key());
        $this->assertSame($this->value, $this->subject->value());
    }

    public function testConstructorDefaults()
    {
        $this->subject = new ProducedEvent($this->sequenceNumber, $this->time);

        $this->assertNull($this->subject->key());
        $this->assertNull($this->subject->value());
    }

    public function testIteration()
    {
        $this->assertSame(array($this->subject), iterator_to_array($this->subject));
    }

    public function testSetCall()
    {
        $call = $this->callFactory->create();
        $this->subject->setCall($call);

        $this->assertSame($call, $this->subject->call());
    }
}
