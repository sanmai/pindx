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

use PHPUnit\Framework\TestCase;
use RussianPostIndex\Util\Deserializer;

/**
 * @covers \RussianPostIndex\Util\ConcreteRecord
 * @covers \RussianPostIndex\Util\Deserializer
 */
class ConcreteRecordTest extends TestCase
{
    public function testExample()
    {
        $deserializer = new Deserializer();

        $record = $deserializer->deserialize('{
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
        }');

        $this->assertSame(123456, $record->getIndex());
        $this->assertSame('Тамбовский', $record->getName());
        $this->assertSame('О', $record->getType());
        $this->assertSame(234567, $record->getSuperior());
        $this->assertSame('Адыгея Республика', $record->getRegion());
        $this->assertSame('Пример', $record->getAutonomousRegion());
        $this->assertSame('Гиагинский район', $record->getArea());
        $this->assertSame('Тамбовский', $record->getCity());
        $this->assertSame('Проверка', $record->getDistrict());
        $this->assertSame('20100914', $record->getDate()->format('Ymd'));
    }
}
