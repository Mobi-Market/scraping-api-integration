<?php

declare(strict_types=1);

/*
 * This file is part of Lifeboat.
 * (c) Mobi-Market <info@mobi-market.co.uk>
 * This source file is proprietary and no license is given for its use outside
 * Mobi-Market.
 */

namespace MobiMarket\ScrapingTool;

use MobiMarket\ScrapingTool\Entities\ApiAuth;
use MobiMarket\ScrapingTool\Traits\RestApiClient;

class ScrapingSolr
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
    public function test(): array
    {
        $query = [
            'q'              => '( title:"p smart")',
            'rows'           => '100000',
            'start'          => '0',
            'sort'           => 'updated_on desc',
            'fl'             => '*',
            'facet'          => 'on',
            'facet_limit'    => '-1',
            'facet_mincount' => '1',
            'facet_fields'   => '[\'status\', \'storage\', \'colour\']',
            'facet_pivot'    => 'domain',
            'wt'             => 'json',
            'timeAllowed'    => '90000',
            'commit'         => 'true',
            'group'          => 'true',
            'group_field'    => 'itemKey',
            'group_limit'    => '1',
            'group_sort'     => 'updated_on desc',
            'group_format'   => 'grouped',
            'group_main'     => 'false',
            'fq'             => '(storage:32GB OR storage:32GB OR storage:"32 GB") AND +status:Fair AND +domain:backmarket.co.uk AND +network:unlocked',
        ];

        return $this->sendAPIRequestNotEmpty('get', 'models/');
    }
}
