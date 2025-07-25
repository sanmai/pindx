---
layout: default
title: "Russian Postal Code Database - Free JSON API"
description: "Free JSON API for Russian postal codes. Official database from Russian Post with comprehensive coverage of all regions, cities, and postal offices."
lang: en
turbo: true
---

Last updated: {{ site.data.status.updated | date: "%B %d, %Y" }}

## What is this?

This is a **free JSON API** for Russian postal codes (zip codes), based on the official database from **Russian Post** (Почта России). The API provides comprehensive information about postal offices, regions, cities, and districts across Russia.

## How it works

Postal code data is available in JSON format at URLs like:

```
https://sanmai.github.io/pindx/json/AAA/AAABBB.json
```

Where `AAA` are the first three digits of the postal code, and `BBB` are the last three.

<span id="example-json">For example, check out [postal code 199151 data](https://sanmai.github.io/pindx/json/199/199151.json).</span>

<script>

(async () => {
    let prefix = await window.fetch('../json/index.json')
        .then(function(response) {
            return response.json();
        }).then(function(json) {
            return json[~~(Math.random() * json.length)];
        });

    let index = await window.fetch('../json/' + prefix + '.json')
        .then(function(response) {
            return response.json();
        }).then(function(json) {
            return json[~~(Math.random() * json.length)];
        });

    let href = '../json/' + prefix + '/' + index + '.json';

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

            let fetchExample = document.getElementById('fetch-example');
            if (fetchExample) {
                fetchExample.innerHTML = fetchExample.innerHTML.replace(/123456/g, index);
                fetchExample.innerHTML = fetchExample.innerHTML.replace(/123/g, prefix);
            }
        });
})();

</script>

This API supports **CORS** (Cross-Origin Resource Sharing), so you can use it directly from web applications. Perfect for validating postal codes in address forms or building location-based services.

**Data Source**: [Official postal code database](https://www.pochta.ru/support/database/ops) from the Russian Post (FGUP "Russian Post"). The database is synchronized with the official source daily. Current version: [{{ site.data.status.updated | date: "%B %d, %Y" }}](https://www.pochta.ru/support/database/ops).

[Report issues here](https://github.com/sanmai/pindx/issues/new)

### Data Fields Description

| Field | Description |
| ---- | ---- |
| Index | Postal code according to the current indexing system |
| OPSName | Name of the postal office |
| OPSType | Type of postal office (О - office, ММПО - mail processing center, etc.) |
| OPSSubm | Index of the superior postal office in hierarchy |
| Region | Name of the region, territory, or republic |
| Autonom | Name of autonomous region (if applicable) |
| Area | Name of district |
| City | Name of city or town |
| City1 | Name of subordinate settlement (if applicable) |
| ActDate | Date when information was last updated (YYYYMMDD format) |
| IndexOld | Old postal code before current indexing system |

## Usage Examples

### Basic fetch() example

<div id="fetch-example" markdown="1">

```javascript
// Get data for postal code 123456
const postalCode = "123456";
const prefix = postalCode.substring(0, 3); // get first 3 digits: "123"

fetch(`https://sanmai.github.io/pindx/json/${prefix}/${postalCode}.json`)
  .then(response => response.json())
  .then(data => {
    console.log('Postal Code:', data.Index);
    console.log('Region:', data.Region);
    console.log('District:', data.Area);
    console.log('City:', data.City);
  })
  .catch(error => console.error('Postal code not found:', error));
```

</div>

### Example with async/await and error handling

```javascript
async function getPostalOffice(postalCode) {
  const prefix = postalCode.substring(0, 3);
  const response = await fetch(`https://sanmai.github.io/pindx/json/${prefix}/${postalCode}.json`);

  if (response.status === 404) {
    return null; // Postal code not found in database
  }

  if (!response.ok) {
    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
  }

  return await response.json();
}

// Usage
(async () => {
  const validCode = "123456";
  const invalidCode = "000000";

  const office = await getPostalOffice(validCode);
  if (office) {
    console.log(`Found: ${office.OPSName}, ${office.Region}`);
  }
  
  const notFound = await getPostalOffice(invalidCode);
  if (!notFound) {
    console.log('Postal code not found in database');
  }
})();

## Why Use This API?

- **100% Free** - No API keys, no rate limits, no registration
- **Always Up-to-Date** - Synchronized daily with official Russian Post database
- **CORS Enabled** - Use directly from web browsers
- **Fast & Reliable** - Hosted on GitHub Pages CDN
- **Comprehensive** - Complete Russian postal code coverage
- **Developer Friendly** - Simple REST API with JSON responses

Perfect for:
- E-commerce address validation
- Shipping calculators
- Location-based services
- Geographic data analysis
- Russian market applications

---

🇷🇺 [Русская версия](../) | 🐙 [GitHub Repository](https://github.com/sanmai/pindx)