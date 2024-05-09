<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
include_once('core/php/Greeter.php');

final class GreeterTest extends TestCase
{
    public function testGreetsWithName(): void
    {
        $greeter = new Greeter;

        $greeting = $greeter->greet('Alice');

        $this->assertSame('Hello, Alice!', $greeting);
    }
}
