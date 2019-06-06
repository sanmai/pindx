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

namespace RussianPostIndex;

interface Record
{
    /**
     * Почтовый индекс объекта почтовой связи в соответствии с действующей системой индексации.
     */
    public function getIndex(): int;

    /**
     * Наименование объекта почтовой связи.
     */
    public function getName(): string;

    /**
     * Тип объекта почтовой связи.
     */
    public function getType(): string;

    /**
     * Индекс вышестоящего по иерархии подчиненности объекта почтовой связи.
     */
    public function getSuperior(): int;

    /**
     * Наименование области, края, республики, в которой находится объект почтовой связи.
     *
     * @var string
     */
    public function getRegion(): string;

    /**
     * Наименование автономной области, в которой находится объект почтовой связи.
     */
    public function getAutonomousRegion(): string;

    /**
     * Наименование района, в котором находится объект почтовой связи.
     */
    public function getArea(): string;

    /**
     * Наименование населенного пункта, в котором находится объект почтовой связи.
     */
    public function getCity(): string;

    /**
     * Наименование подчиненного населенного пункта, в котором находится объект почтовой связи.
     */
    public function getDistrict(): string;

    /**
     * Дата актуализации информации об объекте почтовой связи.
     */
    public function getDate(): \DateTimeInterface;
}
