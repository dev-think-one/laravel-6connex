<?php


namespace LaravelSixConnex\Tests;

use Illuminate\Support\Str;
use LaravelSixConnex\ApiRequest;
use LaravelSixConnex\Facades\SixConnex;

class SixConnexApiTest extends TestCase
{

    /** @test */
    public function make_stage_from_config()
    {
        app()->config->set('sixconnex.options.production', false);
        $this->assertFalse(SixConnex::isProduction());
        $this->assertTrue(
            Str::contains(
                SixConnex::url(),
                app()->config->get('sixconnex.client_domain', 'test')
                . '.6connexstage.'
                . app()->config->get('sixconnex.options.top_level_domain', 'com')
            )
        );
        $this->assertFalse(Str::contains(SixConnex::url(), '.6connex.'));
    }

    /** @test */
    public function make_production_from_config()
    {
        app()->config->set('sixconnex.options.production', true);
        $this->assertTrue(SixConnex::isProduction());
        $this->assertTrue(
            Str::contains(
                SixConnex::url(),
                app()->config->get('sixconnex.client_domain', 'test')
                . '.6connex.'
                . app()->config->get('sixconnex.options.top_level_domain', 'com')
            )
        );
        $this->assertFalse(Str::contains(SixConnex::url(), '.6connexstage.'));
    }

    /** @test */
    public function make_production_onfly()
    {
        app()->config->set('sixconnex.options.production', false);
        $this->assertTrue(SixConnex::env()->isProduction());
        $this->assertTrue(
            Str::contains(
                SixConnex::url(),
                app()->config->get('sixconnex.client_domain', 'test')
                . '.6connex.'
                . app()->config->get('sixconnex.options.top_level_domain', 'com')
            )
        );
        $this->assertFalse(Str::contains(SixConnex::url(), '.6connexstage.'));
    }

    /** @test */
    public function test_api_url_not_empty()
    {
        $this->assertNotEmpty(SixConnex::testApiUrl());
    }

    /** @test */
    public function user_request_return_api_request()
    {
        $this->assertInstanceOf(ApiRequest::class, SixConnex::usersRequest());
    }

    /** @test */
    public function user_request_with_options_return_api_request()
    {
        $this->assertInstanceOf(ApiRequest::class, SixConnex::usersRequest('read', ['email' => 'pieter.tester@6connex.test', 'event_id' => 123]));
    }
}
