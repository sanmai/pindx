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

namespace RussianPostIndex\ByCity\City992;

/**
 * @internal
 */
final class Office992101 implements \RussianPostIndex\Record
{
    use \RussianPostIndex\Util\RecordTrait;

    private $Index = 992101;
    private $OPSName = 'Новокуйбышевск-Почтомат (Апс)';
    private $OPSType = 'Почтомат';
    private $OPSSubm = 446218;
    private $Region = 'Самарская область';
    private $Autonom = '';
    private $Area = '';
    private $City = 'Новокуйбышевск';
    private $City1 = '';
    private $ActDate = '20180329';
    private $IndexOld = '';
}