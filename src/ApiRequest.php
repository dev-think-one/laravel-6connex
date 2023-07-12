<?php


namespace LaravelSixConnex;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class ApiRequest implements CallBody
{
    protected PendingRequest $client;

    protected string $username;
    protected string $password;
    protected string $url;

    protected ?CallBody $call = null;
    /**
     * @var CallBody[]
     */
    protected array $multiplicity = [];

    /**
     * SixConnexRequestBuilder constructor.
     *
     * @param string $username
     * @param string $password
     * @param string $url
     * @param array $options
     */
    public function __construct(string $username, string $password, string $url, array $options = [])
    {
        $this->username = $username;
        $this->password = $password;
        $this->url      = $url;

        $this->call = new SixConnexCall();

        $this->client = Http::withOptions($options['guzzle'] ?? [])
                            ->withHeaders(array_merge([
                                'Content-Type' => 'application/json',
                                'Accept'       => 'application/json',
                            ], ($options['headers'] ?? [])));
    }

    public function addNewCall($call): self
    {
        if (is_array($call)) {
            $this->multiplicity = array_merge($this->multiplicity, $call);
        } elseif ($call instanceof CallBody) {
            $this->multiplicity[] = $call;
        }

        return $this;
    }

    public function addOption($key, $value = null): self
    {
        $this->call->addOption($key, $value);

        return $this;
    }

    public function setApiCall(string $type = 'read'): self
    {
        $this->call->setApiCall($type);

        return $this;
    }

    public function overrideOptions(array $options): self
    {
        $this->call->overrideOptions($options);

        return $this;
    }

    public function getCallBody(): array
    {
        return array_map(fn (CallBody $call) => $call->getCallBody(), array_merge([
            $this->call,
        ], $this->multiplicity));
    }

    protected function body(): array
    {
        return [
            'apiUsername'     => $this->username,
            'apiPassword'     => $this->password,
            'apicallsetinput' => $this->getCallBody(),
        ];
    }

    /**
     * @return SixConnexResponse
     */
    public function call(): SixConnexResponse
    {
        return new SixConnexResponse($this->client->post($this->url, $this->body()));
    }
}
