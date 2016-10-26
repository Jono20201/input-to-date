<?php

namespace Tests\Unit\Helpers;

use Carbon\Carbon;
use InputToDate\InputToDate;
use PHPUnit_Framework_TestCase;

class InputToDateTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_can_be_initialised_without_a_default()
    {
        $i2d = InputToDate::create('12/03/1995')
            ->setFormat('d/m/Y');

        $this->assertEquals('12/03/1995', $i2d->getInput());
        $this->assertEquals('d/m/Y', $i2d->getFormat());
    }

    /** @test */
    public function it_can_be_initialised_with_a_default()
    {
        $now = Carbon::now();

        $i2d = InputToDate::create('12/03/1995')
            ->setFormat('d/m/Y')
            ->setDefault($now);

        $this->assertEquals('12/03/1995', $i2d->getInput());
        $this->assertEquals('d/m/Y', $i2d->getFormat());
        $this->assertEquals($now->timestamp, $i2d->getDefault()->timestamp);
    }

    /** @test */
    public function it_returns_null_when_set_to_return_null()
    {
        $i2d = InputToDate::create('12/03/ddddd1995')
            ->setFormat('d/m/Y')
            ->setReturnNullOnFailure();

        $this->assertEquals(null, $i2d->convert());
    }

    /**
     * @test
     *
     * @expectedException InvalidArgumentException
     */
    public function it_will_throw_exception_without_default_and_invalid_input()
    {
        $i2d = InputToDate::create('12/03/ddddd1995')
            ->setFormat('d/m/Y');

        $this->assertTrue($i2d->willThrowException());

        $i2d->convert();
    }

    /** @test */
    public function it_will_return_valid_carbon_object_on_success()
    {
        $carbon = Carbon::createFromDate(1995, 2, 12);

        $converted = InputToDate::create('12/02/1995')
            ->setFormat('d/m/Y')
            ->convert();

        $this->assertInstanceOf(Carbon::class, $converted);
        $this->assertEquals($carbon->timestamp, $converted->timestamp);
    }

    /** @test */
    public function it_will_return_default_on_failure()
    {
        $default = Carbon::createFromDate(2003, 3, 3);

        $converted = InputToDate::create('03/03/2003')
            ->setFormat('d/m/Y')
            ->setDefault($default)
            ->convert();

        $this->assertEquals($default, $converted);
    }
}
