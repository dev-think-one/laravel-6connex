# Laravel: 6connex API integration

![Packagist License](https://img.shields.io/packagist/l/think.studio/laravel-6connex?color=%234dc71f)
[![Packagist Version](https://img.shields.io/packagist/v/think.studio/laravel-6connex)](https://packagist.org/packages/think.studio/laravel-6connex)
[![Total Downloads](https://img.shields.io/packagist/dt/think.studio/laravel-6connex)](https://packagist.org/packages/think.studio/laravel-6connex)
[![Build Status](https://scrutinizer-ci.com/g/dev-think-one/laravel-6connex/badges/build.png?b=main)](https://scrutinizer-ci.com/g/dev-think-one/laravel-6connex/build-status/main)
[![Code Coverage](https://scrutinizer-ci.com/g/dev-think-one/laravel-6connex/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/dev-think-one/laravel-6connex/?branch=main)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/dev-think-one/laravel-6connex/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/dev-think-one/laravel-6connex/?branch=main)

Documentation [here](docs%2F6Connex_API_REGISTRATION_STEPS.pdf)

## Installation

You can install the package via composer:

```bash
composer require think.studio/laravel-6connex
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="LaravelSixConnex\ServiceProvider" --tag="config"
```
Configuration in *.env*
```dotenv
SIXCONNEX_API_USERNAME="myapp"
SIXCONNEX_API_PASSWORD="apipassword"
```

## Usage example

### Formatted Response

```injectablephp
/** @var SixConnexOutput $output */
$output = SixConnex::usersRequest('read', ['email'=>'pieter.tester@6connex.test', 'event_id' => 123])
    ->call()->outputFirst();
if($output->successful()) {
    $address = $output->json('address1');
    $events = $output->collect('events');
}
```

### Raw response

Call

```injectablephp
SixConnex::usersRequest()->setApiCall('read')
    ->addOption('email', 'pieter.tester@6connex.test')
    ->call()->json();
```
or
```injectablephp
SixConnex::usersRequest()->setApiCall('read')
    ->addOption('email', 'pieter.tester@6connex.test')
    ->addOption('event_id', 123)
    ->call()->json();
```
or
```injectablephp
SixConnex::usersRequest()->setApiCall('read')
    ->addOption(['email'=>'pieter.tester@6connex.test', 'event_id' => 123])
    ->call()->json();
```

Result

```txt
[
 "apicallsetoutput" => [
   [
     "id" => 123,
     "firstname" => "Pieter",
     "lastname" => "Tester",
     "email" => "pieter.tester@6connex.test",
     "company" => "6C",
     "title" => "Mr",
     "address1" => "89 Avenue",
     "zipcode" => "WD60 7DU",
     "city" => "Watford",
     "state_province" => "Herts",
     "country" => "GB",
     "country_code" => "32",
     "area_code" => "00",
     "phone_no" => "00",
     "events" => [
       123 => [
         "event_id" => 123,
         "event_name" => "Online Show",
         "register_date" => "2020-03-29 09:05:14",
         "registrationset_name" => "default set",
         "entitlementgroup_name" => "default group",
       ],
     ],
     "initially_created_by_partner" => false,
     "_apicall" => "read",
     "_apicallresultcode" => 1,
     "_apicallresultmessage" => "success",
   ],
 ],
]
```

### Package also support "multiplicity"

```injectablephp
 SixConnex::usersRequest('read', ['email'=>'test@test1.com', 'event_id' => 123])
     ->addNewCall(
        ( new \LaravelSixConnex\SixConnexCall )
        ->addOption('email', 'test@test2.com')
     )
     ->addNewCall(
        ( new \LaravelSixConnex\SixConnexCall )
        ->addOption(['email' => 'not@in.db'])
     )
     ->call()->json();
```

Result

```txt
[
 "apicallsetoutput" => [
   [
     "id" => 123123,
     "firstname" => "Test",
     "lastname" => "Test",
     "email" => "test@test1.com",
     "title" => "Test",
     "events" => [
       123 => [
         "event_id" => 123,
         "event_name" => "Online Show",
         "register_date" => "2022-04-13 15:53:26",
         "registrationset_name" => "default set",
         "entitlementgroup_name" => "default group",
         "Custom Number:" => "65297",
       ],
     ],
     "initially_created_by_partner" => true,
     "lastmodified" => "2022-04-13 15:53:26",
     "_apicall" => "read",
     "_apicallresultcode" => 1,
     "_apicallresultmessage" => "success",
   ],
   [
     "id" => 234234,
     "firstname" => "Test",
     "lastname" => "Test",
     "email" => "test@test2.com",
     "company" => "Web dev",
     "title" => "MR",
     "events" => [
       123 => [
         "event_id" => 123,
         "event_name" => "Online Show",
         "register_date" => "2022-04-13 15:53:26",
         "registrationset_name" => "default set",
         "entitlementgroup_name" => "default group",
         "Custom Number:" => "NA",
       ],
     ],
     "initially_created_by_partner" => true,
     "lastmodified" => "2022-04-05 11:16:38",
     "_apicall" => "read",
     "_apicallresultcode" => 1,
     "_apicallresultmessage" => "success",
   ],
   [
     "_apicall" => "read",
     "_apicallresultcode" => 0,
     "_apicallresultmessage" => "Email 'not@in.db' not registered in the database",
   ],
 ],
]
```

## Credits

- [![Think Studio](https://yaroslawww.github.io/images/sponsors/packages/logo-think-studio.png)](https://think.studio/)
