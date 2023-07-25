<?php

/**
 * Copyright (c) 2018-2023 Adshares sp. z o.o.
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

namespace Adshares\Adserver\Mail\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SiteAccepted extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        protected string $mediumName,
        protected string $siteName,
        protected string $siteUrl,
    ) {
    }

    public function build(): Mailable
    {
        $label = match ($this->mediumName) {
            'web' => 'Website',
            'metaverse' => 'Metaverse Site',
            default => 'Site',
        };
        $this->subject = sprintf('Good News: Your %s Has Been Approved!', $label);
        return $this->markdown('emails.notifications.site-accepted')
            ->with(
                [
                    'bookingUrl' => config('app.booking_url'),
                    'contactEmail' => config('app.support_email'),
                    'mediumName' => $this->mediumName,
                    'siteName' => $this->siteName,
                    'siteUrl' => $this->siteUrl,
                ]
            );
    }
}