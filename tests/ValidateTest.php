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
use Symfony\Component\Finder\Finder;

/**
 * @coversNothing
 */
class ValidateTest extends TestCase
{
    public function postalCodeProvider()
    {
        if (!file_exists(\PIndxTools\Reader::TSV_SOURCE)) {
            self::markTestSkipped('No data to test with');
        }

        $reader = new \PIndxTools\Reader();

        return \Pipeline\take($reader->read())->map(function (\PIndxTools\Record $record) {
            return [$record->Index];
        });
    }

    /**
     * @dataProvider postalCodeProvider
     *
     * @param mixed $postalCode
     */
    public function testPostalCodeExists($postalCode)
    {
        $this->assertNotNull(\RussianPostIndex\PrefixDirectory::getOffice($postalCode));
    }

    public function postalCodesFromFiles()
    {
        $finder = new Finder();
        $finder->files()->in('src/ByCity/')->name('Office*.php');

        $pipeline = \Pipeline\take($finder);

        $pipeline->map(function (\SplFileInfo $fileInfo) {
            return $fileInfo->getFilename();
        });

        $pipeline->map(function ($filename) {
            return substr($filename, 6, 6);
        });

        $pipeline->map(function ($postalCode) {
            yield $postalCode => [$postalCode];
        });

        return $pipeline;
    }

    /**
     * @dataProvider postalCodesFromFiles
     *
     * @param mixed $postalCode
     */
    public function testPostalCodeIndexed($postalCode)
    {
        $this->assertTrue(\RussianPostIndex\MainDirectory::postalCodeValid($postalCode));
    }
}
