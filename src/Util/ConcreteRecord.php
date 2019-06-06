<?php
/**
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

namespace RussianPostIndex\Util;

use JMS\Serializer\Annotation\Type;

/**
 * @internal
 */
final class ConcreteRecord implements \RussianPostIndex\Record
{
    use \RussianPostIndex\Util\RecordTrait;

    /**
     * @Type("int")
     */
    private $Index;

    /**
     * @Type("string")
     */
    private $OPSName;

    /**
     * @Type("string")
     */
    private $OPSType;

    /**
     * @Type("int")
     */
    private $OPSSubm;

    /**
     * @Type("string")
     */
    private $Region;

    /**
     * @Type("string")
     */
    private $Autonom;

    /**
     * @Type("string")
     */
    private $Area;

    /**
     * @Type("string")
     */
    private $City;

    /**
     * @Type("string")
     */
    private $City1;

    /**
     * @Type("DateTimeImmutable<'Ymd'>")
     *
     * @var \DateTimeImmutable
     */
    private $ActDate;

    /**
     * @Type("string")
     */
    private $IndexOld;
}
