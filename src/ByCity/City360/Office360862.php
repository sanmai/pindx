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

namespace RussianPostIndex\ByCity\City360;

/**
 * @internal
 */
final class Office360862 implements \RussianPostIndex\Record
{
    use \RussianPostIndex\Util\RecordTrait;

    private $Index = 360862;
    private $OPSName = 'Нальчик Почтамт Уч.-2';
    private $OPSType = 'Участок';
    private $OPSSubm = 360000;
    private $Region = 'Кабардино-Балкарская Республика';
    private $Autonom = '';
    private $Area = 'Эльбрусский район';
    private $City = 'Тырныауз';
    private $City1 = '';
    private $ActDate = '20100507';
    private $IndexOld = '';
}
