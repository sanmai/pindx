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

/**
 * @internal
 */
final class Reader
{
    const TSV_SOURCE = 'PIndx.tsv';

    const LOWER_CASE_WORDS = [
        'Район' => 'район',
        'Область' => 'область',
        'Край' => 'край',
        'Округ' => 'округ',
        'Автономный' => 'автономный',
        'Автономная' => 'автономная',
        'Немецкий' => 'немецкий',
        'Национальный' => 'национальный',

        'Аопп' => 'АОПП',
        'Гсп' => 'ГСП',
        'Гцмпп' => 'ГЦМПП',
        'Дти' => 'ДТИ',
        'Ммпо' => 'ММПО',
        'Мрп' => 'МРП',
        'Мсо' => 'МСО',
        'Мсц' => 'МСЦ',
        'Оп ' => 'ОП ',
        'Опп' => 'ОПП',
        'Передвижное Ос' => 'Передвижное ОС',
        'Пждп' => 'ПЖДП',
        'Ппс' => 'ППС',
        'Сц ' => 'СЦ ',
        'Ти ' => 'ТИ ',
        ' Уду' => ' УДУ',
        'Укд' => 'УКД',
        'Умсц' => 'УМСЦ',
        'Уфпс' => 'УФПС',
        'Фгуп' => 'ФГУП',
        'Гуп' => 'ГУП',
        'Ems' => 'EMS',
        'Лпц' => 'ЛПЦ',
        'Пкф' => 'ПКФ',
    ];

    public static function updateCyrillicCasing(string $input): string
    {
        if (PHP_VERSION_ID < 70300) {
            $input = str_replace(['"', '/'], ['"% ', '/% '], $input);
        }

        $output = str_replace(array_keys(self::LOWER_CASE_WORDS), self::LOWER_CASE_WORDS, mb_convert_case($input, MB_CASE_TITLE));

        if (PHP_VERSION_ID < 70300) {
            $output = str_replace(['"% ', '/% '], ['"', '/'], $output);
        }

        return $output;
    }

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
                $record->{$fieldName} = self::updateCyrillicCasing($data[$fieldNo]);
            }

            $record->Index = (int) $record->Index;
            $record->OPSSubm = (int) $record->OPSSubm;

            yield $record;
        }

        fclose($fh);
    }
}
