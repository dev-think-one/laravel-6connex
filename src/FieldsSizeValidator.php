<?php


namespace LaravelSixConnex;

use Illuminate\Support\Str;
use LaravelSixConnex\Exceptions\SixConnexFiledSizeException;

/**
 * Class FieldsSizeValidator
 * @package LaravelSixConnex
 *
 * @method string default( $value )
 * @method string firstname( $value )
 * @method string lastname( $value )
 * @method string email( $value )
 * @method string password( $value )
 * @method string title( $value )
 * @method string company( $value )
 * @method string profile_image( $value )
 * @method string language( $value )
 * @method string entitlement_group( $value )
 * @method string registration_set( $value )
 * @method string address1( $value )
 * @method string address2( $value )
 * @method string zipcode( $value )
 * @method string city( $value )
 * @method string state_province( $value )
 * @method string country( $value )
 * @method string country_code( $value )
 * @method string area_code( $value )
 * @method string phone_no( $value )
 * @method string extension( $value )
 * @method string promo_code( $value )
 */

class FieldsSizeValidator
{
    protected $useLimit = false;

    protected $fields = [
        'default' => 64,
        'firstname' => 64,
        'lastname' => 64,
        'email' => 64,
        'password' => 30,
        'title' => 64,
        'company' => 64,
        'profile_image' => 512,
        'language' => 32,
        'entitlement_group' => 128,
        'registration_set' => 80,
        'address1' => 512,
        'address2' => 512,
        'zipcode' => 16,
        'city' => 64,
        'state_province' => 64,
        'country' => 128,
        'country_code' => 20, // This is the phone number’s country code, not the ISO code of country field.
        'area_code' => 20,
        'phone_no' => 20,
        'extension' => 20,
        'promo_code' => 255,
    ];

    /**
     * FieldsSizeValidator constructor.
     *
     * @param bool $useLimit
     */
    public function __construct(bool $useLimit = false)
    {
        $this->useLimit = $useLimit;
    }

    public function useLimit(bool $useLimit = false)
    {
        $this->useLimit = $useLimit;

        return $this;
    }

    /**
     * @codeCoverageIgnore
     */
    public function __call($name, $arguments)
    {
        if (array_key_exists($name, $this->fields)) {
            if (strlen($arguments[0]) > $this->fields[ $name ]) {
                if ($this->useLimit && ! in_array($name, [
                        'email',
                        'password',
                    ])) {
                    return Str::limit($arguments[0], $this->fields[ $name ], '');
                }

                throw new SixConnexFiledSizeException("$name field not valid");
            }

            return $arguments[0];
        }

        throw new \BadMethodCallException("Method $name not exists");
    }


    public function event_id($id)
    {
        if (! is_numeric($id) || $id <= 0) {
            throw new SixConnexFiledSizeException('Id field not valid');
        }

        return (int) $id;
    }
}
