<?php

declare(strict_types=1);

namespace Imjoehaines\Session\Tests;

use OutOfBoundsException;
use PHPUnit\Framework\TestCase;
use Imjoehaines\Session\Session;

class SessionTest extends TestCase
{
    public function testItReturnsFalseForValuesNotInStorage() : void
    {
        $storage = [];
        $session = new Session($storage);

        $this->assertSame(
            false,
            $session->has('x')
        );
    }

    public function testItReturnsTrueForValuesInStorage() : void
    {
        $storage = ['a' => 1];
        $session = new Session($storage);

        $this->assertSame(
            true,
            $session->has('a')
        );
    }

    public function testItReturnsValueForValuesInStorage() : void
    {
        $storage = ['a' => 1];
        $session = new Session($storage);

        $this->assertSame(
            1,
            $session->get('a')
        );
    }

    public function testItThrowsWhenTryingToGetAValueNotInStorage() : void
    {
        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage('The key "x" was not found in the session');

        $storage = [];
        $session = new Session($storage);

        $session->get('x');
    }

    public function testItAllowsNewValuesToBeSet() : void
    {
        $storage = [];
        $session = new Session($storage);

        $this->assertSame(
            false,
            $session->has('x')
        );

        $session->set('x', 23);

        $this->assertSame(
            true,
            $session->has('x')
        );
        $this->assertSame(
            23,
            $session->get('x')
        );
    }

    public function testItAllowsExistingValuesToBeOverwritten() : void
    {
        $storage = ['a' => 1];
        $session = new Session($storage);

        $this->assertSame(
            true,
            $session->has('a')
        );

        $session->set('a', 888);

        $this->assertSame(
            true,
            $session->has('a')
        );
        $this->assertSame(
            888,
            $session->get('a')
        );
    }

    public function testItAllowsExistingValuesToBeRemoved() : void
    {
        $storage = ['a' => 1];
        $session = new Session($storage);

        $this->assertSame(
            true,
            $session->has('a')
        );

        $session->delete('a');

        $this->assertSame(
            false,
            $session->has('a')
        );
    }

    public function testItThrowsWhenTryingToDeleteAValueNotInStorage() : void
    {
        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage('The key "x" was not found in the session');

        $storage = [];
        $session = new Session($storage);

        $session->delete('x');
    }

    public function testItDetectsSetsFromStorageInTheOutsideWorld() : void
    {
        $storage = ['x' => 999];

        $session = new Session($storage);

        $this->assertSame(
            999,
            $session->get('x')
        );

        $storage['x'] = 333;

        $this->assertSame(
            333,
            $session->get('x')
        );
    }

    public function testItDetectsDeletionsFromStorageInTheOutsideWorld() : void
    {
        $storage = ['x' => 999];

        $session = new Session($storage);

        $this->assertSame(
            true,
            $session->has('x')
        );

        unset($storage['x']);

        $this->assertSame(
            false,
            $session->has('x')
        );
    }

    public function testItCanClearTheSession() : void
    {
        $storage = ['a' => 'b', 'c' => 'd', 'e' => 'f'];

        $session = new Session($storage);

        $this->assertSame(
            true,
            $session->has('a')
        );

        $session->clear();

        $this->assertSame(
            false,
            $session->has('a')
        );

        $this->assertSame(
            [],
            $storage
        );
    }

    public function testItCanClearTheSessionAndStillDetectSetsFromTheOutsideWorld() : void
    {
        $storage = ['a' => 'b', 'c' => 'd', 'e' => 'f'];

        $session = new Session($storage);

        $session->clear();

        $storage['x'] = 'y';

        $this->assertSame(
            ['x' => 'y'],
            $storage
        );
    }
}
