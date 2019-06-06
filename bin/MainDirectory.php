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
$pipeline->map(function (\PIndxTools\Record $record) {
    return $record->Index;
});

$mainDirectory = file_get_contents('src/MainDirectory.php');

ob_start();
echo "[\n\t\t";
echo join(",\n\t\t", $pipeline->toArray());
echo "\n\t]";
$mainDirectory = preg_replace('/INDEX_LIST = \[[^]]*\]/s', 'INDEX_LIST = '.ob_get_clean(), $mainDirectory);

file_put_contents('src/MainDirectory.php', $mainDirectory);
