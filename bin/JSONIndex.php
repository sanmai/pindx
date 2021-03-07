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

if (!is_dir('docs/json')) {
    mkdir('docs/json');
}

$reader = new \PIndxTools\Reader();
$pipeline = \Pipeline\take($reader->read());
$pipeline->map(function (PIndxTools\Record $record) {
    $cityCode = substr((string) $record->Index, 0, 3);

    if (!is_dir("docs/json/$cityCode/")) {
        mkdir("docs/json/$cityCode/");
    }

    yield "docs/json/$cityCode/{$record->Index}.json" => $record;
});

foreach ($pipeline as $filename => $record) {
    file_put_contents($filename, json_encode($record, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
