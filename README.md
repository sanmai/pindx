[![JSON API](https://img.shields.io/badge/json%20api-live-green.svg)](https://sanmai.github.io/pindx/)
[![Continuous Integration](https://github.com/sanmai/pindx/actions/workflows/ci.yaml/badge.svg)](https://github.com/sanmai/pindx/actions/workflows/ci.yaml)
[![Database Update](https://github.com/sanmai/pindx/actions/workflows/update.yaml/badge.svg?event=schedule)](https://github.com/sanmai/pindx/actions/workflows/update.yaml)

# Справочник почтовых индексов 

Для использования предлагается следующий интерфейс:

- [API клиент](https://github.com/sanmai/pindx-client) подразумевает получение данных отделения по [JSON API почтовых индексов](https://sanmai.github.io/pindx/). Это можно сделать только через [запрос к API](https://sanmai.github.io/pindx/).

Источник данных этой библиотеки: [эталонный справочник почтовых индексов объектов почтовой связи](https://www.pochta.ru/support/database/ops) от дирекции технологий и информатизации ФГУП «Почта России».

## JSON

Для вашего удобства все данные из БД [также есть в виде JSON API почтовых индексов](https://sanmai.github.io/pindx/) ([in English](https://sanmai.github.io/pindx/en/)).

API - бесплатное, обратная ссылка - желательна. [Сами файлы.](docs/json)

## Обновление и разработка

Обновление справочника производится в автоматическом режиме вызовом `make`, последующим коммитом и PR. 

## Что за pindx?

Потому что [так называются исходные файлы](https://www.pochta.ru/support/database/ops) от почты. Конечно, они называются используя смешанный регистр, PIndx, но в именах пакетов в Composer не рекомендуется использовать такой формат. Потому `pindx`.

