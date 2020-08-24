<?php

declare(strict_types=1);

namespace MobiMarket\ScrapingTool;

use MobiMarket\ScrapingTool\Entities\ApiAuth;
use MobiMarket\ScrapingTool\Entities\RefurbishedModel;
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
    public function getModels(): array
    {
        return $this->sendAPIRequestNotEmpty('get', 'models/');
    }

    /*
     * POST models
     */
    public function addModel(RefurbishedModel $model): object
    {
        return $this->sendAPIRequestNotEmpty('post', 'models/', $model->toArray());
    }

    /*
     * PUT models/{model_id}/
     */
    public function updateModel(int $model_id, RefurbishedModel $model): object
    {
        return $this->sendAPIRequestNotEmpty('put', "models/{$model_id}/", $model->toArray());
    }

    /*
     * DELETE models/{model_id}/
     */
    public function deleteModel(int $model_id): object
    {
        return $this->sendAPIRequestNotEmpty('delete', "models/{$model_id}/");
    }

    /*
     * GET stores
     */
    public function stores(): array
    {
        return $this->sendAPIRequestNotEmpty('get', 'stores/');
    }

    /*
     * GET storages
     */
    public function storages(): array
    {
        return $this->sendAPIRequestNotEmpty('get', 'storages/');
    }

    /*
     * GET prices/{model_id}?network={network}
     */
    public function getModelPrices(int $model_id, ?string $network = null): object
    {
        $query = $network ? ['network' => $network] : null;

        return $this->sendAPIRequestNotEmpty('get', "prices/{$model_id}/", null, null, $query);
    }

    /*
     * GET prices/?network={network}
     */
    public function getAllPrices(?string $network = null, int $count = 100, int $start = 0): object
    {
        $query = $network ? ['network' => $network] : null;
        $query = $query + [
            'rows_per_page' => $count,
            'start'         => $start,
        ];

        return $this->sendAPIRequestNotEmpty('get', 'prices/', null, null, $query);
    }

    /*
     * GET prices/?network={network}
     */
    public function getAllPricesEx(?array $data = null): object
    {
        $query = $data; // YOU LIAR!

        return $this->sendAPIRequestNotEmpty('get', 'prices/', null, null, $query);
    }
}
