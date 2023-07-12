<?php


namespace LaravelSixConnex\Tests;

use Illuminate\Http\Client\Response;
use LaravelSixConnex\SixConnexResponse;
use Mockery\Mock;

class SixConnexResponseTest extends TestCase
{

    /** @test */
    public function raw_response()
    {
        /** @var Response $spy */
        $spy      = $this->spy(Response::class);
        $response = new SixConnexResponse($spy);

        $this->assertEquals($spy, $response->getRawResponse());
    }

    /** @test */
    public function output_first()
    {
        /** @var Response|Mock $spy */
        $spy      = $this->spy(Response::class);
        $response = new SixConnexResponse($spy);

        $spy->shouldReceive('collect')
            ->once()
            ->with('apicallsetoutput')
            ->andReturn(collect([
                [
                    'test'                  => 'testValue',
                    '_apicall'              => 'read',
                    '_apicallresultcode'    => 1,
                    '_apicallresultmessage' => 'test',
                ],
                [],
            ]));

        $output = $response->outputFirst();

        $this->assertEquals('testValue', $output->json('test'));
        $this->assertTrue($output->successful());
    }

    /** @test */
    public function propangate_call()
    {
        /** @var Response|Mock $spy */
        $spy      = $this->spy(Response::class);
        $response = new SixConnexResponse($spy);

        $spy->shouldReceive('someMethod')
            ->once()
            ->with('data');

        $response->someMethod('data');
    }
}
