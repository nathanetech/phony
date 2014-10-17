<?php

/*
 * This file is part of the Phony package.
 *
 * Copyright © 2014 Erin Millard
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace Eloquent\Phony\Mock\Builder\Exception;

use Exception;
use PHPUnit_Framework_TestCase;

class ClassExistsExceptionTest extends PHPUnit_Framework_TestCase
{
    public function testException()
    {
        $className = 'ClassName';
        $cause = new Exception();
        $exception = new ClassExistsException($className, $cause);

        $this->assertSame($className, $exception->className());
        $this->assertSame("Class 'ClassName' is already defined.", $exception->getMessage());
        $this->assertSame(0, $exception->getCode());
        $this->assertSame($cause, $exception->getPrevious());
    }
}