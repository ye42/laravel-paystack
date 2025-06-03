<?php

namespace Ye42\Paystack\Test;

use Mockery as m;
use PHPUnit\Framework\TestCase;

class HelpersTest extends TestCase {

    protected $paystack;

    public function setUp(): void
    {
        $this->paystack = m::mock('Ye42\Paystack\Paystack');
        $this->mock = m::mock('GuzzleHttp\Client');
    }

    public function tearDown(): void
    {
        m::close();
    }

    /**
     * Tests that helper returns
     *
     * @return void
     */
    public function testItReturnsInstanceOfPaystack()
    {
        $this->assertInstanceOf("Ye42\Paystack\Paystack", $this->paystack);
    }
}