<?php


namespace LaravelSixConnex\Tests;

use LaravelSixConnex\ApiRequest;
use LaravelSixConnex\CallBody;
use LaravelSixConnex\Facades\SixConnex;
use LaravelSixConnex\SixConnexCall;
use LaravelSixConnex\SixConnexResponse;

class SixConnexRequestTest extends TestCase
{

    /** @test */
    public function options_can_be_added_as_array()
    {
        $this->assertInstanceOf(
            ApiRequest::class,
            SixConnex::usersRequest()
                     ->addOption('email', 'test@test.com')
        );

        $this->assertInstanceOf(
            ApiRequest::class,
            $request = SixConnex::usersRequest()
                                ->setApiCall(CallBody::TYPE_CREATE)
                                ->addOption([ 'email' => 'test@test.com' ])
        );

        /** @var CallBody $call */
        $data = $request->getCallBody()[0];

        $this->assertEquals(CallBody::TYPE_CREATE, $data[ SixConnexCall::$typeParameter ]);
        $this->assertEquals('test@test.com', $data['email']);
    }

    /** @test */
    public function options_override()
    {
        $this->assertInstanceOf(
            ApiRequest::class,
            $request = SixConnex::usersRequest()
                                ->addOption('email', 'yaro@test.com')
                                ->addOption('first_name', 'Yaro')
        );

        /** @var CallBody $call */
        $data = $request->getCallBody()[0];

        $this->assertEquals(CallBody::TYPE_READ, $data[ SixConnexCall::$typeParameter ]);
        $this->assertEquals('yaro@test.com', $data['email']);
        $this->assertEquals('Yaro', $data['first_name']);

        $request->overrideOptions([ 'email' => 'test@test.com' ]);

        /** @var CallBody $call */
        $data = $request->getCallBody()[0];

        $this->assertEquals(CallBody::TYPE_READ, $data[ SixConnexCall::$typeParameter ]);
        $this->assertEquals('test@test.com', $data['email']);
        $this->assertNotContains('first_name', $data);
    }

    /** @test */
    public function call_respond_response()
    {
        $this->assertInstanceOf(
            SixConnexResponse::class,
            SixConnex::usersRequest()
                     ->addOption('email', 'test@test.com')
                     ->call()
        );
    }

    /** @test */
    public function user_can_add_multiple_calls()
    {
        $request = SixConnex::usersRequest()
                            ->addOption('email', 'test@test.com')
                            ->addNewCall(( new SixConnexCall )->addOption('email', 'other@test.com'));

        $this->assertCount(2, $request->getCallBody());


        $request = SixConnex::usersRequest()
                            ->addOption('email', 'test@test.com')
                            ->addNewCall([
                                ( new SixConnexCall )->addOption('email', 'other@test.com'),
                                ( new SixConnexCall )->addOption('email', 'other2@test.com'),
                            ]);

        $this->assertCount(3, $request->getCallBody());
    }
}
