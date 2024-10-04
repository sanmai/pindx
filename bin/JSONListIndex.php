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
use PIndxTools\Reader;
use PIndxTools\Record;

require 'vendor/autoload.php';

if (!is_dir('docs/json')) {
    mkdir('docs/json');
}

$reader = new Reader();
$pipeline = \Pipeline\take($reader->read());
$pipeline->map(static function (Record $record) {
    yield $record->Index;
});

$result = $pipeline->reduce(static function (array $carry, int $index) {
    $cityCode = substr((string) $index, 0, 3);

    $carry[$cityCode][$index] = $index;

    return $carry;
}, []);

foreach ($result as $cityCode => $postCodes) {
    file_put_contents("docs/json/{$cityCode}.json", json_encode(array_values($postCodes), JSON_PRETTY_PRINT));
}

file_put_contents('docs/json/index.json', json_encode(array_keys($result), JSON_PRETTY_PRINT));
