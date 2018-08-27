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

namespace PIndxTools;

class Reader
{
    const TSV_SOURCE = 'PIndx.tsv';

    /**
     * @param string|resource $input
     *
     * @return \Generator|\PIndxTools\Record[]
     */
    public function read($input = self::TSV_SOURCE): \Generator
    {
        $fields = array_keys(get_object_vars(new Record()));

        $fh = is_resource($input) ? $input : fopen($input, 'rb');
        while (($data = fgetcsv($fh, 2048, "\t")) !== false) {
            $record = new Record();

            foreach ($fields as $fieldNo => $fieldName) {
                $record->{$fieldName} = $data[$fieldNo];
            }

            $record->Index = (int) $record->Index;
            $record->OPSSubm = (int) $record->OPSSubm;

            yield $record;
        }

        fclose($fh);
    }
}