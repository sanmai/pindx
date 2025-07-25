---
layout: default
title: "Справочник почтовых индексов почты России"
turbo: true
---

Последнее обновление: {{ site.data.status.updated | date: "%d.%m.%Y" }}

## Как это работает?

Данные по почтовым индексам доступны в формате JSON по адресам вида:

```
https://sanmai.github.io/pindx/json/AAA/AAABBB.json
```

Где `AAA` - первые три цифры индекса, `BBB` - последние три.

<span id="example-json">Например, посмотрите [данные для индекса 199151](https://sanmai.github.io/pindx/json/199/199151.json).</span>

<script>

(async () => {
    let prefix = await window.fetch('./json/index.json')
        .then(function(response) {
            return response.json();
        }).then(function(json) {
            return json[~~(Math.random() * json.length)];
        });

    let index = await window.fetch('./json/' + prefix + '.json')
        .then(function(response) {
            return response.json();
        }).then(function(json) {
            return json[~~(Math.random() * json.length)];
        });

    let href = './json/' + prefix + '/' + index + '.json';

    window.fetch(href)
        .then(function(response) {
            return response.json();
        }).then(function(json) {
            let example = document.getElementById('example-json');

            let pre = document.createElement("pre");
            pre.innerHTML = JSON.stringify(json, null, 2);
            example.appendChild(pre);

            let a = example.querySelector('a');
            a.href = href;
            a.innerHTML = a.innerHTML.replace(/\d+/gi, index);

            // Update fetch example with the actual postal code
            let fetchExample = document.getElementById('fetch-example');
            if (fetchExample) {
                fetchExample.innerHTML = fetchExample.innerHTML.replace(/123456/g, index);
                fetchExample.innerHTML = fetchExample.innerHTML.replace(/123/g, prefix);
            }
        });
})();

</script>

На этом сайте разрешены AJAX-запросы со сторонних сайтов (стоит разрешающий заголовок `Access-Control-Allow-Origin`). Например, мы можете проверять корректность ввода индекса в форме адреса.

Источник данных: [эталонный справочник почтовых индексов объектов почтовой связи](https://www.pochta.ru/support/database/ops) от дирекции технологий и информатизации ФГУП «Почта России». Сверка с исходным справочником происходит один раз в день. Сейчас используется [БД от {{ site.data.status.updated | date: "%d.%m.%Y" }}](https://www.pochta.ru/support/database/ops).

[О проблемах сообщайте.](https://github.com/sanmai/pindx/issues/new)

### Описание полей данных

| Поле | Описание |
| ---- | ---- |
| Index  | Почтовый индекс объекта почтовой связи в соответствии с действующей системой индексации.  |
| OPSName  | Наименование объекта почтовой связи.  |
| OPSType  | Тип объекта почтовой связи. |
| OPSSubm  | Индекс вышестоящего по иерархии подчиненности объекта почтовой связи.  |
| Region  |  Наименование области, края, республики, в которой находится объект почтовой связи. |
| Autonom  | Наименование автономной области, в которой находится объект почтовой связи.  |
| Area  | Наименование района, в котором находится объект почтовой связи.  |
| City  | Наименование населенного пункта, в котором находится объект почтовой связи.  |
| City1  | Наименование подчиненного населенного пункта, в котором находится объект почтовой связи.  |
| ActDate  | Дата актуализации информации об объекте почтовой связи.  |
| IndexOld  | Почтовый индекс объект почтовой связи до ввода действующей системы индексации.  |

## Пример использования с `fetch()`

<div id="fetch-example">

```javascript
// Получаем данные для индекса 123456
const postalCode = 123456;
const prefix = Math.floor(postalCode / 1000); // получаем первые 3 цифры: 123

fetch(`https://sanmai.github.io/pindx/json/${prefix}/${postalCode}.json`)
  .then(response => response.json())
  .then(data => {
    console.log('Индекс:', data.Index);
    console.log('Регион:', data.Region);
    console.log('Район:', data.Area);
    console.log('Город:', data.City);
  })
  .catch(error => console.error('Ошибка:', error));
```

</div>

## PHP клиент для доступа к API

Установка делается как обычно. Требуется PHP 7.0 и выше.

```
composer require sanmai/pindx-client
```

Пример использования:

```php
<?php
require 'vendor/autoload.php';

$postalCode = 130980;

$client = new \RussianPostIndex\Client();
if ($office = $client->getOffice($postalCode)) {
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
}
```

Более подробно [в документации к библиотеке](https://github.com/sanmai/pindx#%D1%81%D0%BF%D1%80%D0%B0%D0%B2%D0%BE%D1%87%D0%BD%D0%B8%D0%BA-%D0%BF%D0%BE%D1%87%D1%82%D0%BE%D0%B2%D1%8B%D1%85-%D0%B8%D0%BD%D0%B4%D0%B5%D0%BA%D1%81%D0%BE%D0%B2).

