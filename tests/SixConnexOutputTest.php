<?php


namespace LaravelSixConnex\Tests;

use LaravelSixConnex\SixConnexOutput;

class SixConnexOutputTest extends TestCase
{

    /** @test */
    public function output_info()
    {
        $output = new SixConnexOutput([
            'test'                  => 'testValue',
            '_apicall'              => 'create',
            '_apicallresultcode'    => 0,
            '_apicallresultmessage' => 'test message',
        ]);

        $this->assertEquals('create', $output->getApiCall());
        $this->assertEquals('test message', $output->getResultMessage());
        $this->assertEquals(0, $output->getCode());
        $this->assertFalse($output->successful());
        $this->assertTrue($output->failed());
        $this->assertCount(1, $output->collect('test'));
        $this->assertCount(4, $output->json());
    }
}
