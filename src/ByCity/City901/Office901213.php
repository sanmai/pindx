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

namespace RussianPostIndex\ByCity\City901;

class Office901213 implements \RussianPostIndex\Record
{
    use \RussianPostIndex\Util\RecordTrait;

    private $Index = 901213;
    private $OPSName = 'ПВ БАРНАУЛ-САНКТ-ПЕТЕРБУРГ';
    private $OPSType = 'ТИ';
    private $OPSSubm = 656960;
    private $Region = 'АЛТАЙСКИЙ КРАЙ';
    private $Autonom = '';
    private $Area = '';
    private $City = 'БАРНАУЛ';
    private $City1 = '';
    private $ActDate = '20140519';
    private $IndexOld = '';
}
