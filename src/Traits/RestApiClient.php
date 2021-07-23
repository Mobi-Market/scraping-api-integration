<?php

declare(strict_types=1);

namespace MobiMarket\ScrapingTool\Traits;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use MobiMarket\ScrapingTool\Entities\ApiAuth;
use MobiMarket\ScrapingTool\Exceptions\RequestFailed;
use MobiMarket\ScrapingTool\Exceptions\UnexpectedResponse;
use Psr\Http\Message\ResponseInterface as HttpResponse;

trait RestApiClient
{
    /**
     * @var HttpClient
     */
    protected $client;

    /**
     * @var ApiAuth
     */
    protected $auth;

    /**
     * Sets up require parameters for the api.
     */
    public function buildClient(
        string $base_uri,
        float $timeout,
        bool $should_log,
        ApiAuth $auth
    ): void {
        $stack = HandlerStack::create();

        if (true === $should_log) {
            $stack->push(
                Middleware::log(
                    Log::getLogger(),
                    new MessageFormatter('{req_body} - {res_body}'),
                    'debug'
                )
            );

            $stack->push(
                Middleware::log(
                    Log::getLogger(),
                    new MessageFormatter('{uri} - {method} - {code}'),
                    'debug'
                )
            );
        }

        $this->auth = $auth;

        $this->client = new HttpClient([
            // Base URI is used with relative requests
            'base_uri'    => $base_uri,
            // You can set any number of default request options.
            'timeout'     => $timeout,
            // Handler stack for logging purposes.
            'handler'     => $stack,
            // Disable internal errors to let us catch all status codes.
            'http_errors' => false,
        ]);
    }

    /**
     * Send the request to the API.
     */
    protected function sendAPIRequest(
        string $method,
        string $endpoint,
        ?array $data = null,
        ?array $headers = null,
        ?array $query = null,
        bool $dot = true
    ) {
        $body           = null;
        $contentHeaders = [
            'Accept'        => 'application/json',
            'Authorization' => 'Basic ' . \base64_encode("{$this->auth->username}:{$this->auth->password}"),
        ];

        if ($data) {
            $body                           = \json_encode($data);
            $contentHeaders['Content-Type'] = 'application/json';
        }

        if ($query && $dot) {
            $query = Arr::dot($query);
        }

        $headers = $headers ?? [];

        /**
         * @var HttpResponse
         */
        $response = $this->client->{$method}($endpoint, [
            'body'      => $body,
            'query'     => $query,
            'headers'   => $headers + $contentHeaders,
        ]);

        $code = $response->getStatusCode();

        // Codes from 400 to 5XX are errors
        if ($code >= 400 && $code <= 599) {
            throw new RequestFailed($response);
        }

        $body = (string) $response->getBody();

        return \json_decode($body) ?? $body;
    }

    protected function sendAPIRequestNotEmpty(
        string $method,
        string $endpoint,
        ?array $data = null,
        ?array $headers = null,
        ?array $query = null,
        bool $dot = true
    ) {
        if ($response = $this->sendAPIRequest($method, $endpoint, $data, $headers, $query, $dot)) {
        } else {
            throw new UnexpectedResponse('Response is empty');
        }

        return $response;
    }
}
