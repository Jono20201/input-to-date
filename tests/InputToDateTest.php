<?php

namespace Tests\Unit\Helpers;

use Carbon\Carbon;
use InputToDate\InputToDate;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class InputToDateTest extends PHPUnit_Framework_TestCase
{

    /** @test */
    public function it_can_be_created_via_constructor()
    {
        $carbon = Carbon::create(1995, 03, 12);

        $i2d = (new InputToDate('d/m/Y'))
            ->setInput('12/03/1995');

        $this->assertEquals('12/03/1995', $i2d->getInput());
        $this->assertEquals('d/m/Y', $i2d->getFormat());
        $this->assertTrue($carbon->eq($i2d->convert()));
    }

    /** @test */
    public function it_can_be_initialised_without_a_default()
    {
        $carbon = Carbon::create(1995, 03, 12);

        $i2d = InputToDate::create('d/m/Y')
            ->setInput('12/03/1995');

        $this->assertEquals('12/03/1995', $i2d->getInput());
        $this->assertEquals('d/m/Y', $i2d->getFormat());
        $this->assertTrue($carbon->eq($i2d->convert()));
    }


    /** @test */
    public function it_can_be_initialised_with_a_default()
    {
        $now = Carbon::now();

        $i2d = InputToDate::create('d/m/Y')
            ->setInput('12/03/1995')
            ->setDefault($now);

        $this->assertEquals('12/03/1995', $i2d->getInput());
        $this->assertEquals('d/m/Y', $i2d->getFormat());
        $this->assertTrue($now->eq($i2d->getDefault()));
    }

    /** @test */
    public function it_returns_null_when_set_to_return_null()
    {
        $i2d = InputToDate::create()
            ->setInput('12/03/ddddd1995')
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
        $i2d = InputToDate::create()
            ->setInput('12/03/ddddd1995')
            ->setFormat('d/m/Y');

        $this->assertTrue($i2d->willThrowException());
        $this->expectException(InvalidArgumentException::class);

        $i2d->convert();
    }

    /** @test */
    public function it_will_return_valid_carbon_object_on_success()
    {
        $carbon = Carbon::createFromDate(1995, 2, 12);

        $converted = InputToDate::create()
            ->setFormat('d/m/Y')
            ->convert('12/02/1995');

        $this->assertInstanceOf(Carbon::class, $converted);
        $this->assertTrue($carbon->eq($converted));
    }

    /** @test */
    public function it_will_return_default_on_failure()
    {
        $default = Carbon::createFromDate(2016, 3, 3);

        $converted = InputToDate::create('d/m/Y')
            ->setDefault($default)
            ->convert('03/03/2003 20:00:00');

        $this->assertEquals($default, $converted);
    }

    /** @test */
    public function it_can_accept_user_input_on_convert_method()
    {
        $carbon = Carbon::createFromDate(2003, 3, 20);

        $converted = InputToDate::create('d/m/Y')
            ->convert('20/03/2003');

        $this->assertEquals($carbon, $converted);
    }
}
