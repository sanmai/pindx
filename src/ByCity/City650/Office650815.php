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

namespace RussianPostIndex\ByCity\City650;

/**
 * @internal
 */
final class Office650815 implements \RussianPostIndex\Record
{
    use \RussianPostIndex\Util\RecordTrait;

    private $Index = 650815;
    private $OPSName = 'Кемерово-ДТИ';
    private $OPSType = 'ДТИ';
    private $OPSSubm = 650070;
    private $Region = 'Кемеровская область';
    private $Autonom = '';
    private $Area = '';
    private $City = 'Кемерово';
    private $City1 = '';
    private $ActDate = '20180424';
    private $IndexOld = '';
}