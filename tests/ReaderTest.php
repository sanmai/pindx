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
 * @covers \PIndxTools\Reader
 */
class ReaderTest extends TestCase
{
    public function testSimpleRead()
    {
        $fh = tmpfile();
        fwrite($fh, "101000\tМОСКВА\tО\t127950\tМОСКВА\t\t\t\t\t20110121\t\t\n");
        rewind($fh);

        $reader = new \PIndxTools\Reader();
        foreach ($reader->read($fh) as $rec) {
            break;
        }

        $this->assertSame(101000, $rec->Index);
        $this->assertSame('Москва', $rec->OPSName);
        $this->assertSame(127950, $rec->OPSSubm);
        $this->assertSame('20110121', $rec->ActDate);

        foreach ($reader->read($fh) as $rec) {
            continue;
        }

        $this->assertFalse(is_resource($fh));
    }

    public function testUpdateCyrillicCasing()
    {
        $this->assertSame('Москва', \PIndxTools\Reader::updateCyrillicCasing('МОСКВА'));
        $this->assertSame('Ненецкий автономный округ', \PIndxTools\Reader::updateCyrillicCasing('НЕНЕЦКИЙ АВТОНОМНЫЙ ОКРУГ'));
        $this->assertSame('Люберецкий район', \PIndxTools\Reader::updateCyrillicCasing('ЛЮБЕРЕЦКИЙ РАЙОН'));
        $this->assertSame('Саратовская область, Красноармейский район', \PIndxTools\Reader::updateCyrillicCasing('САРАТОВСКАЯ ОБЛАСТЬ, КРАСНОАРМЕЙСКИЙ РАЙОН'));
        $this->assertSame('Саха (Якутия) Республика', \PIndxTools\Reader::updateCyrillicCasing('САХА (ЯКУТИЯ) РЕСПУБЛИКА'));
        $this->assertSame('Тюменская область', \PIndxTools\Reader::updateCyrillicCasing('ТЮМЕНСКАЯ ОБЛАСТЬ'));
        $this->assertSame('Казанский ЛПЦ ММПО Цех EMS', \PIndxTools\Reader::updateCyrillicCasing('КАЗАНСКИЙ ЛПЦ ММПО ЦЕХ EMS'));
    }
}
