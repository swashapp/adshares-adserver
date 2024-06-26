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

namespace Adshares\Supply\Domain\Model;

use Adshares\Common\Domain\Id;
use Adshares\Supply\Domain\ValueObject\BannerUrl;
use Adshares\Supply\Domain\ValueObject\Classification;
use Adshares\Supply\Domain\ValueObject\Exception\UnsupportedBannerTypeException;
use Adshares\Supply\Domain\ValueObject\Status;

class Banner
{
    public const TYPE_HTML = 'html';
    public const TYPE_IMAGE = 'image';
    public const TYPE_DIRECT_LINK = 'direct';
    public const TYPE_VIDEO = 'video';
    public const TYPE_MODEL = 'model';

    public const SUPPORTED_TYPES = [
        self::TYPE_HTML,
        self::TYPE_IMAGE,
        self::TYPE_DIRECT_LINK,
        self::TYPE_VIDEO,
        self::TYPE_MODEL,
    ];

    private Id $id;

    private Campaign $campaign;

    private BannerUrl $bannerUrl;

    private string $type;

    private ?string $mime;

    private string $size;

    private Status $status;

    private string $checksum;

    /** @var Classification[] */
    private array $classification;

    private Id $demandBannerId;

    public function __construct(
        Campaign $campaign,
        Id $id,
        Id $demandBannerId,
        BannerUrl $bannerUrl,
        string $type,
        ?string $mime,
        string $size,
        string $checksum,
        Status $status,
        array $classification = []
    ) {
        if (!in_array($type, self::SUPPORTED_TYPES, true)) {
            throw new UnsupportedBannerTypeException(sprintf(
                'Unsupported banner `%s` type. Only %s are allowed.',
                $type,
                implode(',', self::SUPPORTED_TYPES)
            ));
        }

        $this->id = $id;
        $this->campaign = $campaign;
        $this->bannerUrl = $bannerUrl;
        $this->type = $type;
        $this->mime = $mime;
        $this->size = $size;
        $this->status = $status;
        $this->checksum = $checksum;
        $this->classification = $classification;
        $this->demandBannerId = $demandBannerId;
    }

    public function activate(): void
    {
        $this->status = Status::active();
    }

    public function delete(): void
    {
        $this->status = Status::deleted();
    }

    public function classify(Classification $classification): void
    {
        $this->classification[] = $classification;
    }

    public function removeClassification(Classification $classification): void
    {
        foreach ($this->classification as $key => $item) {
            if ($classification->equals($item)) {
                unset($this->classification[$key]);
            }
        }
    }

    public function unclassified(): void
    {
        $this->classification = [];
    }

    public function toArray(): array
    {
        $classification = [];
        foreach ($this->classification as $classificationItem) {
            $classification[$classificationItem->getClassifier()] = $classificationItem->getKeywords();
        }

        return [
            'id' => $this->getId(),
            'demand_banner_id' => $this->getDemandBannerId(),
            'type' => $this->getType(),
            'mime' => $this->getMime(),
            'size' => $this->size,
            'checksum' => $this->checksum,
            'serve_url' => $this->bannerUrl->getServeUrl(),
            'click_url' => $this->bannerUrl->getClickUrl(),
            'view_url' => $this->bannerUrl->getViewUrl(),
            'status' => $this->status->getStatus(),
            'classification' => $classification,
        ];
    }

    public function getId(): string
    {
        return (string)$this->id;
    }

    public function getDemandBannerId(): string
    {
        return (string)$this->demandBannerId;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getMime(): ?string
    {
        return $this->mime;
    }

    public function getCampaignId(): string
    {
        return $this->campaign->getId();
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function getStatus(): int
    {
        return $this->status->getStatus();
    }

    public function getChecksum(): string
    {
        return $this->checksum;
    }

    public function getClassification(): ?array
    {
        return $this->classification;
    }
}
