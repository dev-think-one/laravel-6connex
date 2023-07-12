<?php


namespace LaravelSixConnex;

use \LaravelSixConnex\Exceptions\SixConnexException;

class SixConnexCall implements CallBody
{
    public static string $typeParameter = '_apicall';

    protected string $type;
    protected array $options;

    public function __construct(array $options = [], ?string $type = null)
    {
        $this->options = $options;
        $this->setApiCall($type ?? static::TYPE_READ);
    }

    public function setApiCall(string $type = 'read'): self
    {
        if (!in_array($type, [
            static::TYPE_READ,
            static::TYPE_READALL,
            static::TYPE_CREATE,
            static::TYPE_UPDATE,
            static::TYPE_DELETE,
        ])) {
            throw new SixConnexException('Not valid ' . static::$typeParameter);
        }
        $this->type = $type;

        return $this;
    }

    public function options(): array
    {
        return $this->options;
    }

    /**
     * @param $key
     * @param null $value
     *
     * @return $this
     */
    public function addOption($key, $value = null): self
    {
        if (is_array($key)) {
            $this->options = array_merge($this->options, $key);
        } else {
            $this->options[ $key ] = $value;
        }

        return $this;
    }

    public function overrideOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function getCallBody(): array
    {
        return array_merge($this->options, [
            static::$typeParameter => $this->type,
        ]);
    }
}
