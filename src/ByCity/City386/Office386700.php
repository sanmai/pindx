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

namespace RussianPostIndex\ByCity\City386;

/**
 * @internal
 */
final class Office386700 implements \RussianPostIndex\Record
{
    use \RussianPostIndex\Util\RecordTrait;

    private $Index = 386700;
    private $OPSName = 'УФПС Республики Ингушетия';
    private $OPSType = 'УФПС';
    private $OPSSubm = 0;
    private $Region = 'Ингушетия Республика';
    private $Autonom = '';
    private $Area = '';
    private $City = 'Магас';
    private $City1 = '';
    private $ActDate = '20180813';
    private $IndexOld = '';
}