---
layout: default
title: "JSON API: Справочник почтовых индексов почты России"
---

# Справочник почтовых индексов почты России

Данные по почтовым индексам доступны по адресам вида:

```
https://www.postindexapi.ru/json/AAA/AAABBB.json
```

Например, посмотрите [данные для индекса 199151](https://www.postindexapi.ru/json/199/199151.json). <span id="example-json"></span>

<script>
window.fetch('https://www.postindexapi.ru/json/199/199151.json')
  .then(function(response) {
    return response.json();
  }).then(function(json) {
    var pre = document.createElement("pre");
    pre.innerHTML = JSON.stringify(json, null, 2);
    document.getElementById('example-json').appendChild(pre);
  });
</script>

Разрешены AJAX-запросы со сторонних сайтов (стоит разрешающий заголовок `Access-Control-Allow-Origin`).

Источник данных: [эталонный справочник почтовых индексов объектов почтовой связи](http://vinfo.russianpost.ru/database/ops.html) от дирекции технологий и информатизации ФГУП «Почта России».

[О проблемах сообщайте.](https://github.com/sanmai/pindx/issues/new)

