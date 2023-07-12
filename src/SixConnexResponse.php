<?php


namespace LaravelSixConnex;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;

/**
 * Class SixConnexResponse
 *
 * @method string body()
 */
class SixConnexResponse
{
    protected Response $raw;

    protected ?Collection $apicallsetoutput = null;

    /**
     * SixConnexResponse constructor.
     *
     * @param Response $rawResponse
     */
    public function __construct(Response $rawResponse)
    {
        $this->raw = $rawResponse;
    }

    /**
     * @return Response
     */
    public function getRawResponse(): Response
    {
        return $this->raw;
    }

    /**
     * @return  Collection
     */
    public function outputCollection(): Collection
    {
        if (!$this->apicallsetoutput) {
            $this->apicallsetoutput = $this->raw
                ->collect('apicallsetoutput')
                ->map(fn ($body) => new SixConnexOutput($body));
        }

        return $this->apicallsetoutput;
    }

    /**
     * @return  SixConnexOutput
     */
    public function outputFirst(): SixConnexOutput
    {
        return $this->outputCollection()->first();
    }

    /**
     * Dynamically proxy other methods to the underlying response.
     *
     * @param string $method
     * @param array $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->raw->{$method}(...$parameters);
    }
}
