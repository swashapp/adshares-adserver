<?php

/**
 * Copyright (c) 2018-2022 Adshares sp. z o.o.
 *
 * This file is part of AdServer
 *
 * AdServer is free software: you can redistribute and/or modify it
 * under the terms of the GNU General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * AdServer is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with AdServer. If not, see <https://www.gnu.org/licenses/>
 */

declare(strict_types=1);

namespace Adshares\Demand\Application\Service;

use Adshares\Adserver\Models\BidStrategy;
use Adshares\Common\Application\Dto\TaxonomyV2;
use Adshares\Common\Application\Service\AdUser;
use Adshares\Common\Application\Service\ConfigurationRepository;

class TargetingOptionsImporter
{
    private AdUser $client;
    private ConfigurationRepository $repository;

    public function __construct(AdUser $client, ConfigurationRepository $repository)
    {
        $this->client = $client;
        $this->repository = $repository;
    }

    public function import(): void
    {
        $taxonomy = $this->client->fetchTargetingOptions();
        $this->repository->storeTaxonomyV2($taxonomy);
        $this->registerBidStrategyIfNewMedium($taxonomy);
    }

    private function registerBidStrategyIfNewMedium(TaxonomyV2 $taxonomy): void
    {
        foreach ($taxonomy->getMedia() as $mediumObject) {
            BidStrategy::registerIfMissingDefault(
                sprintf('Default %s', $mediumObject->getVendorLabel() ?: $mediumObject->getLabel()),
                $mediumObject->getName(),
                $mediumObject->getVendor(),
            );
        }
    }
}
