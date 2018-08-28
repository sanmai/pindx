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
 * @covers \RussianPostIndex\PrefixDirectory
 */
class PrefixDirectoryTest extends TestCase
{
    public function testPostalCodeValid()
    {
        $this->assertTrue(\RussianPostIndex\PrefixDirectory::postalCodeValid(997060));

        $this->assertTrue(\RussianPostIndex\PrefixDirectory::postalCodeValid(105005));
        $this->assertTrue(\RussianPostIndex\PrefixDirectory::postalCodeValid(105010));
        $this->assertTrue(\RussianPostIndex\PrefixDirectory::postalCodeValid(105980));
    }

    public function testPostalCodeInvalid()
    {
        $this->assertFalse(\RussianPostIndex\PrefixDirectory::postalCodeValid(999999));

        $this->assertFalse(\RussianPostIndex\PrefixDirectory::postalCodeValid(105001));
        $this->assertFalse(\RussianPostIndex\PrefixDirectory::postalCodeValid(105003));
        $this->assertFalse(\RussianPostIndex\PrefixDirectory::postalCodeValid(105981));
    }

    public function testMissingOffice()
    {
        $this->assertNull(\RussianPostIndex\PrefixDirectory::getOffice(999999));
        $this->assertNull(\RussianPostIndex\PrefixDirectory::getOffice(105001));
        $this->assertNull(\RussianPostIndex\PrefixDirectory::getOffice(105010));
    }

    public function testValidOffice()
    {
        $this->assertInstanceOf(\RussianPostIndex\Record::class, \RussianPostIndex\PrefixDirectory::getOffice(105005));

        $office101000 = \RussianPostIndex\PrefixDirectory::getOffice(101000);
        $this->assertInstanceOf(\RussianPostIndex\Record::class, $office101000);

        $this->assertSame(101000, $office101000->getIndex());
        $this->assertSame('Москва', $office101000->getName());
        $this->assertSame('О', $office101000->getType());
        $this->assertSame(127950, $office101000->getSuperior());
        $this->assertSame('Москва', $office101000->getRegion());
        $this->assertSame('', $office101000->getAutonomousRegion());
        $this->assertSame('', $office101000->getArea());
        $this->assertSame('', $office101000->getCity());
        $this->assertSame('', $office101000->getDistrict());
        $this->assertSame('2011-01-21', $office101000->getDate()->format('Y-m-d'));
    }
}
