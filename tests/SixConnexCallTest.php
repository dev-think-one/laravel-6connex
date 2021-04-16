<?php


namespace LaravelSixConnex\Tests;

use LaravelSixConnex\CallBody;
use LaravelSixConnex\Exceptions\SixConnexException;
use LaravelSixConnex\SixConnexCall;

class SixConnexCallTest extends TestCase
{

    /** @test */
    public function get_options()
    {
        $newCall = (new SixConnexCall(['email' => 'user@test.com']))->setApiCall(CallBody::TYPE_READ);

        $this->assertEquals('user@test.com', $newCall->options()['email']);
    }

    /** @test */
    public function invalid_type_throw_error()
    {
        $this->expectException(SixConnexException::class);

        (new SixConnexCall())->setApiCall('bla-bla');
    }
}
