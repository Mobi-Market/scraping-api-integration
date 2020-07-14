<?php

declare(strict_types=1);

namespace MobiMarket\ScrapingTool;

use MobiMarket\ScrapingTool\Entities\ApiAuth;
use MobiMarket\ScrapingTool\Traits\RestApiClient;

class ScrapingRestApi
{
    use RestApiClient;

    public function __construct(
        string $base_uri,
        float $timeout,
        bool $should_log,
        ApiAuth $auth
    ) {
        $this->buildClient(
            $base_uri,
            $timeout,
            $should_log,
            $auth
        );
    }

    /*
     * GET models
     */
    public function getModels(): object
    {
        return $this->sendAPIRequestNotEmpty('get', 'models');
    }

    /*
     * POST models
     */
    public function postModels(array $data): object
    {
        return $this->sendAPIRequestNotEmpty('post', 'models', $data);
    }

    /*
     * GET stores
     */
    public function stores(): object
    {
        return $this->sendAPIRequestNotEmpty('get', 'stores');
    }

    /*
     * GET prices/{model_id}?network={network}
     */
    public function getModelPrices(int $model_id, ?string $network = null): object
    {
        $query = $network ? ['network' => $network] : null;

        return $this->sendAPIRequestNotEmpty('get', "prices/{$model_id}", null, null, $query);
    }

    /*
     * GET prices/?network={network}
     */
    public function getAllPrices(?string $network = null): object
    {
        $query = $network ? ['network' => $network] : null;

        return $this->sendAPIRequestNotEmpty('get', 'prices', null, null, $query);
    }

    /*
     * GET prices/?network={network}
     */
    public function getAllPricesEx(?string $network = null, ?array $data = null): object
    {
        $query = $network ? ['network' => $network] : null;

        return $this->sendAPIRequestNotEmpty('post', 'prices', $data, null, $query);
    }
}
