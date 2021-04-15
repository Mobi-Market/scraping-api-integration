<?php

declare(strict_types=1);

/*
 * This file is part of Lifeboat.
 * (c) Mobi-Market <info@mobi-market.co.uk>
 * This source file is proprietary and no license is given for its use outside
 * Mobi-Market.
 */

namespace MobiMarket\ScrapingTool;

use Carbon\Carbon;
use MobiMarket\ScrapingTool\Entities\ApiAuth;
use MobiMarket\ScrapingTool\Traits\RestApiClient;

class ScrapingSolr
{
    use RestApiClient;

    protected $baseQuery = [
        'sort'           => 'updated_on desc',
        'fl'             => '*',
        'facet'          => 'on',
        'facet.limit'    => '-1',
        'facet.mincount' => '1',
        'facet.fields'   => '[\'status\', \'storage\', \'colour\']',
        'facet.pivot'    => 'domain',
        'wt'             => 'json',
        'timeAllowed'    => 90000,
        'commit'         => 'true',
        'group'          => 'true',
        'group.field'    => 'itemKey',
        'group.limit'    => 1,
        'group.sort'     => 'updated_on desc',
        'group.format'   => 'grouped',
        'group.main'     => false,
    ];

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
    public function search(bool $sell, ?string $q, int $dayLimit = 7, int $rows = 100, int $start = 0, array $extra = []): array
    {
        $begin = Carbon::now()->subDay($dayLimit)->startOfDay()->toIso8601ZuluString();
        $query = [
            'q'      => $q ?: '*',
            'fq'     => '+updated_on:[' . $begin . ' TO NOW] AND -(-network:unlocked network:*) AND +sell:' . ($sell ? 'true' : 'false'),
            'rows'   => $rows,
            'start'  => $start,
        ] + $this->baseQuery + $extra;

        $data = $this->sendAPIRequestNotEmpty('get', '/solr/mobimarket/select', ['params' => $query], null, null, false);#
        return $data->grouped->itemKey->groups;
    }

    /*
     * GET models
     */
    public function recurse(bool $sell, callable $callback, int $dayLimit = 7, int $rows = 100, array $extra = []): void
    {
        $begin = Carbon::now()->subDay($dayLimit)->startOfDay()->toIso8601ZuluString();
        $query = [
            'q'      => '*',
            'fq'     => '+updated_on:[' . $begin . ' TO NOW] AND -(-network:unlocked network:*) AND +sell:' . ($sell ? 'true' : 'false'),
            'rows'   => $rows,
            'start'  => 0,
        ] + $this->baseQuery + $extra;

        $recurse = true;
        while ($recurse) {
            $data  = $this->sendAPIRequestNotEmpty('get', '/solr/mobimarket/select', ['params' => $query], null, null, false);
            $docs  = $data->grouped->itemKey->groups;
            $count = $data->grouped->itemKey->matches;

            $callback($docs, $sell);

            $query['start'] += $rows;
            if ($count <= $query['start'] || \count($docs) <= 0) {
                $recurse = false;
            }
        }
    }
}
