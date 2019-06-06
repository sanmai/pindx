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

trait RecordTrait
{
    public function getIndex(): int
    {
        return $this->Index;
    }

    public function getName(): string
    {
        return $this->OPSName;
    }

    public function getType(): string
    {
        return $this->OPSType;
    }

    public function getSuperior(): int
    {
        return $this->OPSSubm;
    }

    public function getRegion(): string
    {
        return $this->Region;
    }

    public function getAutonomousRegion(): string
    {
        return $this->Autonom;
    }

    public function getArea(): string
    {
        return $this->Area;
    }

    public function getCity(): string
    {
        return $this->City;
    }

    public function getDistrict(): string
    {
        return $this->City1;
    }

    public function getDate(): \DateTimeInterface
    {
        if ($this->ActDate instanceof \DateTimeImmutable) {
            return $this->ActDate;
        }

        return new \DateTimeImmutable($this->ActDate);
    }
}
