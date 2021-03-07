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
    $cityCode = substr((string) $record->Index, 0, 3);

    $record->namespace = "RussianPostIndex\\ByCity\\City$cityCode";
    $dir = "src/ByCity/City$cityCode";

    if (!is_dir($dir)) {
        exec('mkdir -p '.escapeshellarg($dir));
    }

    yield "$dir/Office{$record->Index}.php" => $record;
});

$vars = array_keys(get_object_vars(new \PIndxTools\Record()));

foreach ($pipeline as $filename => $record) {
    $className = basename($filename, '.php');

    ob_start();

    echo "<?php\n\nnamespace {$record->namespace};\n";

    echo "/**\n";
    echo " * @internal\n";
    echo " */\n";
    echo "final class $className implements \RussianPostIndex\Record\n{\nuse \RussianPostIndex\Util\RecordTrait;\n\n";

    foreach ($vars as $varName) {
        echo "private \${$varName} = ";
        var_export($record->{$varName});
        echo ";\n";
    }

    echo "\n}";
    if (!file_put_contents($filename, ob_get_clean())) {
        echo "Failed saving $filename\n";
        exit(1);
    }
}
