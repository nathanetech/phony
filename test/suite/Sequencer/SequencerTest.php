<?php

/*
 * This file is part of the Phony package.
 *
 * Copyright © 2014 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Eloquent\Phony\Sequencer;

use PHPUnit_Framework_TestCase;

class SequencerTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->subject = new Sequencer();
    }

    public function testConstructor()
    {
        $this->assertSame(-1, $this->subject->get());
    }

    public function testSet()
    {
        $this->subject->set(111);

        $this->assertSame(111, $this->subject->get());
    }

    public function testNext()
    {
        $this->assertSame(0, $this->subject->next());
        $this->assertSame(1, $this->subject->next());
        $this->assertSame(2, $this->subject->next());
    }
}