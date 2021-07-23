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

use function Later\later;
use morphos\Russian\GeographicalNamesInflection;

/**
 * @internal
 */
final class Reader
{
    public const TSV_SOURCE = 'PIndx.tsv';

    public const LOWER_CASE_WORDS = [
        'Район' => 'район',
        'Область' => 'область',
        'Край' => 'край',
        'Округ' => 'округ',
        'Автономный' => 'автономный',
        'Немецкий' => 'немецкий',
        'Национальный' => 'национальный',

        'Ивц' => 'ИВЦ',
        'Мр' => 'МР',
        'Лц' => 'ЛЦ',
        'См' => 'СМ',
        'Аопп' => 'АОПП',
        'Тмц' => 'ТМЦ',
        'Апс' => 'АПС',
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
        'Уду' => 'УДУ',
        'Укд' => 'УКД',
        'Умсц' => 'УМСЦ',
        'Уфпс' => 'УФПС',
        'Фгуп' => 'ФГУП',
        'Гуп' => 'ГУП',
        'Ems' => 'EMS',
        'Лпц' => 'ЛПЦ',
        'Пкф' => 'ПКФ',
        'Lc/Ao' => 'LC/AO',
        'Ти' => 'ТИ',
    ];

    private static function makeWordBoundaryRegEx(string $word): string
    {
        return \sprintf('#\b%s\b#u', $word);
    }

    public static function updateCyrillicCasing(string $input): string
    {
        static $patterns;

        $patterns = $patterns ?? later(function (): iterable {
            $patterns = [];

            $generatePairs = (function () {
                foreach (self::LOWER_CASE_WORDS as $word => $replacement) {
                    yield $word => $replacement;

                    if (\mb_strtolower($replacement) !== $replacement) {
                        continue;
                    }

                    foreach (GeographicalNamesInflection::getCases($replacement) as $case) {
                        yield $case => \mb_strtolower($case);
                    }

                    $replacement = \preg_replace('/[иы]й$/u', 'ая', $replacement, 1, $count);

                    if (1 !== $count) {
                        continue;
                    }

                    foreach (GeographicalNamesInflection::getCases($replacement) as $case) {
                        yield $case => \mb_strtolower($case);
                    }
                }
            })();

            foreach ($generatePairs as $word => $replacement) {
                $patterns[self::makeWordBoundaryRegEx($word)] = $replacement;
            }

            yield $patterns;
        });

        $output = \mb_convert_case($input, MB_CASE_TITLE);

        foreach ($patterns->get() as $regex => $replacement) {
            $output = \preg_replace($regex, $replacement, $output);
        }

        return $output;
    }

    /**
     * @param resource|string $input
     *
     * @return \Generator|\PIndxTools\Record[]
     */
    public function read($input = self::TSV_SOURCE): \Generator
    {
        $fields = \array_keys(\get_object_vars(new Record()));

        $fh = \is_resource($input) ? $input : \fopen($input, 'r');
        while (($data = \fgetcsv($fh, 2048, "\t")) !== false) {
            $record = new Record();

            foreach ($fields as $fieldNo => $fieldName) {
                $record->{$fieldName} = self::updateCyrillicCasing($data[$fieldNo]);
            }

            $record->Index = (int) $record->Index;
            $record->OPSSubm = (int) $record->OPSSubm;

            yield $record;
        }

        \fclose($fh);
    }
}
