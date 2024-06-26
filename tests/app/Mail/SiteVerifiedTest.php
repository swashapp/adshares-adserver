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

namespace Adshares\Adserver\Tests\Mail;

use Adshares\Adserver\Mail\SiteVerified;

class SiteVerifiedTest extends MailTestCase
{
    public function testBuild(): void
    {
        $mailable = new SiteVerified(
            [
                [
                    'name' => 'test-site-example',
                    'url' => 'https://example.com',
                ],
                [
                    'name' => 'test-site-adshares',
                    'url' => 'https://adshares.net',
                ],
            ]
        );

        $mailable->assertSeeInText('test-site-example');
        $mailable->assertSeeInHtml('https://example.com');
        $mailable->assertSeeInText('test-site-adshares');
        $mailable->assertSeeInHtml('https://adshares.net');
    }
}
