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

include 'vendor/autoload.php';

$postalCode = 130980;
$office = \RussianPostIndex\PrefixDirectory::getOffice($postalCode);

var_dump($office->getIndex()); // int(130980)
var_dump($office->getName()); // string(25) "Москва EMS ММПО"
var_dump($office->getType()); // string(8) "ММПО"
var_dump($office->getSuperior()); // int(104040)
var_dump($office->getRegion()); // string(12) "Москва"
var_dump($office->getAutonomousRegion()); // string(0) ""
var_dump($office->getArea()); // string(0) ""
var_dump($office->getCity()); // string(0) ""
var_dump($office->getDistrict()); // string(0) ""
var_dump($office->getDate()->format('Y-m-d')); // string(10) "2017-04-28"

$postalCode = 130980;
$postalCodeValid = \RussianPostIndex\MainDirectory::postalCodeValid($postalCode);
var_dump($postalCodeValid);
// bool(true)
