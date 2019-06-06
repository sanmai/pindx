<?php
/**
 * Copyright 2018 Alexey Kopytko <alexey@kopytko.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

declare(strict_types=1);

namespace RussianPostIndex;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use RussianPostIndex\Util\Deserializer;

final class Client
{
    const BASE_URL = 'https://www.postindexapi.ru';

    const DEFAULT_TIMEOUT = 10;

    /** @var ClientInterface */
    private $http;

    /** @var Deserializer */
    private $deserializer;

    public function __construct(ClientInterface $http = null)
    {
        $this->http = $http ?? new \GuzzleHttp\Client([
            'base_uri' => self::BASE_URL,
            'timeout' => self::DEFAULT_TIMEOUT,
        ]);

        $this->deserializer = new Deserializer();
    }

    /**
     * @param string|int $postalCode
     *
     * @return \RussianPostIndex\Record|null
     */
    public function getOffice($postalCode)
    {
        $postalCode = (string) $postalCode;

        $cityCode = substr($postalCode, 0, 3);

        try {
            $response = $this->http->request('GET', sprintf('/json/%s/%s.json', $cityCode, $postalCode));
        } catch (ClientException $e) {
            if ($e->getCode() === 404) {
                return null;
            }

            throw $e;
        }

        return $this->deserializer->deserialize($response->getBody());
    }
}
