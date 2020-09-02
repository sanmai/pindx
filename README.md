[![Latest Stable Version](https://poser.pugx.org/sanmai/pindx/v/stable)](https://packagist.org/packages/sanmai/pindx)
[![Build Status](https://travis-ci.com/sanmai/pindx.svg?branch=master)](https://travis-ci.com/sanmai/pindx)
[![JSON API](https://img.shields.io/badge/json%20api-live-green.svg)](https://www.postindexapi.ru/)

# Справочник почтовых индексов 

Установка делается как обычно.

```
composer require sanmai/pindx
```

Для использования предлагаются три интерфейса.

- С помощью первого можно получить данные конкретного отделения в офлайн режиме, из локальной копии базы данных индексов.
- Второй интерфейс подразумевает получение данных отделения по [JSON API почтовых индексов](https://www.postindexapi.ru/). Это можно сделать только через запрос к API, потому этот метод работает более медленно, чем первый. С другой стороны, использование этого метода исключает необходимость время от времени обновлять версию пакета для обновления базы индексов.
- Третий предназначен для пакетной проверки большого числа индексов, по локальной копии БД.

Источник данных этой библиотеки: [эталонный справочник почтовых индексов объектов почтовой связи](http://vinfo.russianpost.ru/database/ops.html) от дирекции технологий и информатизации ФГУП «Почта России».

## Получение данных отделения из локальной копии БД

```php
$office = \RussianPostIndex\PrefixDirectory::getOffice($postalCode);
```
Возвращает или объект имплементирующий интерфейс `Record`, или, если такого отделения нет, `null`. Нет необходимости как-то отдельно проверять корректность индекса. Если индекса в БД нет, то вернётся `null`.

Интерфейс объекта содержит следующие методы для получения данных об отделении:

```php
/**
 * Почтовый индекс объекта почтовой связи в соответствии с действующей системой индексации.
 */
$office->getIndex();

/**
 * Наименование объекта почтовой связи.
 */
$office->getName();

/**
 * Тип объекта почтовой связи.
 */
$office->getType();

/**
 * Индекс вышестоящего по иерархии подчиненности объекта почтовой связи.
 */
$office->getSuperior();

/**
 * Наименование области, края, республики, в которой находится объект почтовой связи.
 */
$office->getRegion();

/**
 * Наименование автономной области, в которой находится объект почтовой связи.
 */
$office->getAutonomousRegion();

/**
 * Наименование района, в котором находится объект почтовой связи.
 */
$office->getArea();

/**
 * Наименование населенного пункта, в котором находится объект почтовой связи.
 */
$office->getCity();

/**
 * Наименование подчиненного населенного пункта, в котором находится объект почтовой связи.
 */
$office->getDistrict();

/**
 * Дата актуализации информации об объекте почтовой связи. 
 * @return DateTimeInterface
 */
$office->getDate();
```

### Пример использования

```php
<?php
require 'vendor/autoload.php';

$postalCode = 130980;
if ($office = \RussianPostIndex\PrefixDirectory::getOffice($postalCode)) {
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
## Получение данных отделения используя JSON API

```php
$client = new \RussianPostIndex\Client();
$office = $client->getOffice(101000);
```
Возвращает или объект имплементирующий интерфейс `Record`, или, если такого отделения нет, `null`. Нет необходимости как-то отдельно проверять корректность индекса. Если индекса в БД нет, то вернётся `null`.

Конструктор класса `\RussianPostIndex\Client` опционально берёт на вход стандартный [интерфейс клиента Guzzle](http://docs.guzzlephp.org/en/stable/quickstart.html#making-a-request), что позволяет добавить подключение через прокси или поменять используемый сервер, поднять таймауты для соединения.

### Пример использования

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

## Проверка индекса

Метод для проверки индексов загружает весь список индексов в память, потому проверка индексов происходит быстрее, без обращения к файловой системе. Соответственно, первичная загрузка БД занимает ощутимое время и этот метод не имеет смысла использовать для проверки одного-двух-трёх индексов.

```php
$postalCode = 130980;
$postalCodeValid = \RussianPostIndex\MainDirectory::postalCodeValid($postalCode);
var_dump($postalCodeValid);
// bool(true)
```
Существуют способы ещё более ускорить работу алгоритма проверки индексов, с большим использованием памяти и существенно более медленной инициализацией поискового индекса. В этой библиотеке такие методы пока не имплементированы.

## JSON

Для вашего удобства все данные из БД [также есть в виде JSON API почтовых индексов](https://www.postindexapi.ru/).

API - бесплатное, обратная ссылка - желательна. [Сами файлы.](docs/json)

## Обновление и разработка

Обновление справочника производится в автоматическом режиме вызовом `make`, последующим коммитом и PR. 

## Что за pindx?

Потому что [так называются исходные файлы](http://vinfo.russianpost.ru/database/ops.html) от почты. Конечно, они называются используя смешанный регистр, PIndx, но в именах пакетов в Composer не рекомендуется использовать такой формат. Потому pindx.

