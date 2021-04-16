<?php


namespace LaravelSixConnex\Tests;

use Illuminate\Support\Str;
use LaravelSixConnex\Exceptions\SixConnexFiledSizeException;
use LaravelSixConnex\FieldsSizeValidator;

class FieldsSizeValidatorTest extends TestCase
{
    /** @test */
    public function validator_return_limits()
    {
        $validator = new FieldsSizeValidator(true);
        $this->assertEquals(64, strlen($validator->firstname(Str::random(100))));
        $this->assertEquals(30, strlen($validator->firstname(Str::random(30))));
    }

    /** @test */
    public function validator_return_exception()
    {
        $validator = new FieldsSizeValidator();
        $this->assertEquals(30, strlen($validator->firstname(Str::random(30))));
        $this->expectException(SixConnexFiledSizeException::class);
        $validator->firstname(Str::random(100));
    }

    /** @test */
    public function validator_return_always_exception()
    {
        $validator = new FieldsSizeValidator(true);
        $this->expectException(SixConnexFiledSizeException::class);
        $validator->email(Str::random(100));
        $this->expectException(SixConnexFiledSizeException::class);
        $validator->password(Str::random(100));
    }

    /** @test */
    public function validate_use_limit()
    {
        $validator = new FieldsSizeValidator(true);
        $this->assertEquals(20, strlen($validator->country_code(Str::random(100))));

        $this->expectException(SixConnexFiledSizeException::class);
        $validator->useLimit(false)->country_code(Str::random(100));
    }

    /** @test */
    public function validate_event_id()
    {
        $validator = new FieldsSizeValidator(true);
        $this->assertEquals(30, $validator->event_id(30));

        $this->expectException(SixConnexFiledSizeException::class);
        $validator->event_id('no_id');
    }
}
