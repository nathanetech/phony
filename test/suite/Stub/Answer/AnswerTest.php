<?php

namespace Eloquent\Phony\Stub\Answer;

use Eloquent\Phony\Call\Arguments;
use PHPUnit\Framework\TestCase;

class AnswerTest extends TestCase
{
    protected function setUp()
    {
        $this->primaryRequest = new CallRequest('implode', Arguments::create(), false, false, false);
        $this->secondaryRequestA = new CallRequest('implode', Arguments::create(), false, false, false);
        $this->secondaryRequestB = new CallRequest('implode', Arguments::create(), false, false, false);
        $this->secondaryRequests = [$this->secondaryRequestA, $this->secondaryRequestB];
        $this->subject = new Answer($this->primaryRequest, $this->secondaryRequests);
    }

    public function testConstructor()
    {
        $this->assertSame($this->primaryRequest, $this->subject->primaryRequest());
        $this->assertSame($this->secondaryRequests, $this->subject->secondaryRequests());
    }
}
