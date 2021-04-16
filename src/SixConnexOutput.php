<?php


namespace LaravelSixConnex;

use Illuminate\Support\Collection;

class SixConnexOutput
{
    public static string $typeParameter = '_apicall';
    public static string $codeParameter = '_apicallresultcode';
    public static string $messageParameter = '_apicallresultmessage';

    protected array $body = [];

    /**
     * SixConnexOutput constructor.
     *
     * @param array $body
     */
    public function __construct(array $body)
    {
        $this->body = $body;
    }

    /**
     * Get call type
     * @return string
     */
    public function getApiCall(): string
    {
        return (string) $this->body[ static::$typeParameter ] ?? '';
    }

    /**
     * Get 6connex response code
     * @return int
     */
    public function getCode(): int
    {
        return (int) ($this->body[ static::$codeParameter ] ?? 0);
    }

    /**
     * Get result message
     * @return string
     */
    public function getResultMessage(): string
    {
        return (string) ($this->body[ static::$messageParameter ] ?? '');
    }

    /**
     * Get the JSON decoded body of the response as an array or scalar value.
     *
     * @param string|null $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function json($key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->body;
        }

        return data_get($this->body, $key, $default);
    }

    /**
     * Get the JSON decoded body of the response as a collection.
     *
     * @param  string|null  $key
     * @return \Illuminate\Support\Collection
     */
    public function collect($key = null)
    {
        return Collection::make($this->json($key));
    }

    public function successful(): bool
    {
        return $this->getCode() == 1;
    }

    public function failed(): bool
    {
        return ! $this->successful();
    }
}
