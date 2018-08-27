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
 * @covers \RussianPostIndex\MainDirectory
 */
class MainDirectoryTest extends TestCase
{
    public function testPostalCodeValid()
    {
        $this->assertTrue(\RussianPostIndex\MainDirectory::postalCodeValid(997060));

        $this->assertTrue(\RussianPostIndex\MainDirectory::postalCodeValid(105005));
        $this->assertTrue(\RussianPostIndex\MainDirectory::postalCodeValid(105043));
        $this->assertTrue(\RussianPostIndex\MainDirectory::postalCodeValid(105980));
    }

    public function testPostalCodeInvalid()
    {
        $this->assertFalse(\RussianPostIndex\MainDirectory::postalCodeValid(999999));

        $this->assertFalse(\RussianPostIndex\MainDirectory::postalCodeValid(105001));
        $this->assertFalse(\RussianPostIndex\MainDirectory::postalCodeValid(105003));
        $this->assertFalse(\RussianPostIndex\MainDirectory::postalCodeValid(105981));
    }
}