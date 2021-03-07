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
require 'vendor/autoload.php';

$reader = new \PIndxTools\Reader();
$pipeline = \Pipeline\take($reader->read());
$pipeline->map(function (PIndxTools\Record $record) {
    return $record->Index;
});
$pipeline->map('strval');

$fullTree = [];
foreach ($pipeline as $index) {
    @$fullTree[(int) substr($index, 0, 3)][] = (int) substr($index, 3);
}

$tree = [];

foreach ($fullTree as $cityCode => $officeCodes) {
    $tree[$cityCode] = [min($officeCodes), max($officeCodes)];
}

/*
 * В России принята 6-значная система XXXYYY, где XXX — код города, а YYY — номер почтового отделения,
 * однако многие крупные города, такие как, например, Москва или Санкт-Петербург, имеют несколько кодов города.
 */

$mainDirectory = file_get_contents('src/PrefixDirectory.php');

ob_start();

echo str_replace(['array (', '  ', ')', ' 0 => ', ' 1 => ', "=> \n"], ['[', '        ', ']', '', '', "=>\n"], var_export($tree, true));

$mainDirectory = preg_replace('/CITY_LIST = \[[^;]*\]/s', 'CITY_LIST = '.ob_get_clean(), $mainDirectory);

file_put_contents('src/PrefixDirectory.php', $mainDirectory);
