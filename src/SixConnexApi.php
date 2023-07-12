<?php


namespace LaravelSixConnex;

use Illuminate\Support\Str;

class SixConnexApi
{
    protected string $clientDomain;

    protected string $username;

    protected string $password;

    protected string $topLevelDomain;

    protected bool $ssl;

    protected bool $production;

    protected array $guzzle;

    public function __construct(string $clientDomain, string $username, string $password, array $options = [])
    {
        $this->clientDomain = $clientDomain;
        $this->username     = $username;
        $this->password     = $password;

        $this->topLevelDomain = (string) ($options['top_level_domain'] ?? 'com');
        $this->ssl            = (bool) ($options['ssl'] ?? true);
        $this->production     = (bool) ($options['production'] ?? true);
        $this->guzzle         = $options['guzzle'] ?? [];
    }

    public function isProduction(): bool
    {
        return $this->production;
    }

    /**
     * @param bool $production
     *
     * @return $this
     */
    public function env(bool $production = true): self
    {
        $this->production = $production;

        return $this;
    }

    /**
     * Base url
     *
     * @param string $path
     *
     * @return string
     */
    public function url(string $path = ''): string
    {
        $middle   = $this->production ? '6connex' : '6connexstage';
        $protocol = $this->ssl ? 'https' : 'http';

        $base = "{$protocol}://{$this->clientDomain}.{$middle}.{$this->topLevelDomain}";
        if ($path && !Str::startsWith($path, '/')) {
            $path = "/$path";
        }

        return "{$base}{$path}";
    }

    /**
     * Link to testing page
     * @return string
     */
    public function testApiUrl(): string
    {
        return $this->url('publicapi/test-apis');
    }

    public function usersRequest(?string $apiCall = null, ?array $options = null): ApiRequest
    {
        $request = new ApiRequest(
            $this->username,
            $this->password,
            $this->url('/publicapi/users/executeAPIcall'),
            [ 'guzzle' => $this->guzzle, ]
        );
        if ($apiCall) {
            $request->setApiCall($apiCall);
        }
        if ($options) {
            $request->addOption($options);
        }

        return $request;
    }
}
