<?php
/*
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

/**
 * @covers \PIndxTools\Record
 */
class RecordTest extends TestCase
{
    public function testInterface()
    {
        $record = new \PIndxTools\Record();
        $record->Index = 100100;
        $record->OPSName = 'Testing';
        $record->OPSType = 'TST';
        $record->OPSSubm = 100000;
        $record->Region = 'Region';
        $record->Autonom = 'AO';
        $record->Area = 'Test';
        $record->City = 'Example';
        $record->City1 = 'District';
        $record->ActDate = '20010102';

        $this->assertSame(100100, $record->getIndex());
        $this->assertSame('Testing', $record->getName());
        $this->assertSame('TST', $record->getType());
        $this->assertSame(100000, $record->getSuperior());
        $this->assertSame('Region', $record->getRegion());
        $this->assertSame('AO', $record->getAutonomousRegion());
        $this->assertSame('Test', $record->getArea());
        $this->assertSame('Example', $record->getCity());
        $this->assertSame('District', $record->getDistrict());
        $this->assertSame('2001-01-02', $record->getDate()->format('Y-m-d'));
    }
}
