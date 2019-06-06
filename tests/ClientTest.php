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

namespace Tests\PIndxTools;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use RussianPostIndex\Client;

/**
 * @covers \RussianPostIndex\Client
 */
class ClientTest extends TestCase
{
    private $lastRequest = [];

    private function getHttpClient($responseBody)
    {
        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($responseBody);

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')->willReturn($stream);

        $http = $this->createMock(ClientInterface::class);
        $http->method('request')->will($this->returnCallback(function ($method, $address, array $options) use ($response) {
            $this->lastRequest = [
                $method,
                $address,
            ];

            return $response;
        }));

        return $http;
    }

    public function testCanProcessResponse()
    {
        $client = new Client($this->getHttpClient('{
          "Index": 123456,
          "OPSName": "Тамбовский",
          "OPSType": "О",
          "OPSSubm": 234567,
          "Region": "Адыгея Республика",
          "Autonom": "Пример",
          "Area": "Гиагинский район",
          "City": "Тамбовский",
          "City1": "Проверка",
          "ActDate": "20100914",
          "IndexOld": "111222"
        }'));

        $response = $client->getOffice(111222);

        $this->assertInstanceOf(\RussianPostIndex\Record::class, $response);
        $this->assertSame(123456, $response->getIndex());

        $this->assertSame([
            'GET',
            '/json/111/111222.json',
        ], $this->lastRequest);
    }

    public function testCanHandleError404()
    {
        $client = new Client($http = $this->getHttpClient(''));

        $http->method('request')->will($this->returnCallback(function () {
            $responseMock = $this->createMock(ResponseInterface::class);
            $responseMock->method('getStatusCode')->willReturn(404);

            throw new ClientException('', $this->createMock(RequestInterface::class), $responseMock);
        }));

        $this->assertNull($client->getOffice(111222));
    }

    public function testCanHandleError50x()
    {
        $client = new Client($http = $this->getHttpClient(''));

        $http->method('request')->will($this->returnCallback(function () {
            throw new ServerException('', $this->createMock(RequestInterface::class), $this->createMock(ResponseInterface::class));
        }));

        $this->expectException(ServerException::class);
        $client->getOffice(111222);
    }
}
