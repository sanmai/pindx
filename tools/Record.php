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

namespace PIndxTools;

use RussianPostIndex\Util\RecordTrait;

/**
 * Данные из исходного файла.
 *
 * @internal
 */
final class Record implements \RussianPostIndex\Record
{
    use RecordTrait;

    /**
     * Почтовый индекс объекта почтовой связи в соответствии с действующей системой индексации.
     *
     * @var int
     */
    public $Index;

    /**
     * Наименование объекта почтовой связи.
     *
     * @var string
     */
    public $OPSName;

    /**
     * Тип объекта почтовой связи.
     *
     * @var string
     */
    public $OPSType;

    /**
     * Индекс вышестоящего по иерархии подчиненности объекта почтовой связи.
     *
     * @var int
     */
    public $OPSSubm;

    /**
     * Наименование области, края, республики, в которой находится объект почтовой связи.
     *
     * @var string
     */
    public $Region;

    /**
     * Наименование автономной области, в которой находится объект почтовой связи.
     *
     * @var string
     */
    public $Autonom;

    /**
     * Наименование района, в котором находится объект почтовой связи.
     *
     * @var string
     */
    public $Area;

    /**
     * Наименование населенного пункта, в котором находится объект почтовой связи.
     *
     * @var string
     */
    public $City;

    /**
     * Наименование подчиненного населенного пункта, в котором находится объект почтовой связи.
     *
     * @var string
     */
    public $City1;

    /**
     * Дата актуализации информации об объекте почтовой связи.
     *
     * @var string
     */
    public $ActDate;

    /**
     * Почтовый индекс объект почтовой связи до ввода действующей системы индексации.
     *
     * @var string
     */
    public $IndexOld;
}
