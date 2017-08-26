<?php

namespace Eloquent\Phony\Call\Exception;

use PHPUnit\Framework\TestCase;

class UndefinedArgumentExceptionTest extends TestCase
{
    public function testException()
    {
        $index = 111;
        $exception = new UndefinedArgumentException($index);

        $this->assertSame($index, $exception->index());
        $this->assertSame('No argument defined for index 111.', $exception->getMessage());
        $this->assertSame(0, $exception->getCode());
        $this->assertNull($exception->getPrevious());
    }
}
