---
layout: default
title: "Справочник почтовых индексов почты России"
turbo: true
---

## Как это работает?

Данные по почтовым индексам доступны в формате JSON по адресам вида:

```
https://www.postindexapi.ru/json/AAA/AAABBB.json
```

Где `AAA` - первые три цифры индекса, `BBB` - последние три.

<span id="example-json">Например, посмотрите [данные для индекса 199151](https://www.postindexapi.ru/json/199/199151.json).</span>

<script>

(async () => {
    let prefix = await window.fetch('/json/index.json')
        .then(function(response) {
            return response.json();
        }).then(function(json) {
            return json[~~(Math.random() * json.length)];
        });

    let index = await window.fetch('/json/' + prefix + '.json')
        .then(function(response) {
            return response.json();
        }).then(function(json) {
            return json[~~(Math.random() * json.length)];
        });

    let href = '/json/' + prefix + '/' + index + '.json';

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
        });
})();

</script>

На этом сайте разрешены AJAX-запросы со сторонних сайтов (стоит разрешающий заголовок `Access-Control-Allow-Origin`). Например, мы можете проверять корректность ввода индекса в форме адреса.

Источник данных: [эталонный справочник почтовых индексов объектов почтовой связи](http://vinfo.russianpost.ru/database/ops.html) от дирекции технологий и информатизации ФГУП «Почта России». Сверка с исходным справочником происходит один раз в день. Сейчас используется БД от {{ site.data.status.updated | date: "%d.%m.%Y" }}.

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