---
layout: default
title: "Russian Postal Code Database - Free JSON API"
description: "Free JSON API for Russian postal codes. Official database from Russian Post with coverage of all regions, cities, and postal offices."
lang: en
turbo: true
---

Last updated: {{ site.data.status.updated | date: "%B %d, %Y" }}

## What is this?

A free JSON API for Russian postal codes, built from the [official Russian Post database](https://www.pochta.ru/support/database/ops). Get detailed information about any postal office, region, city, or district across Russia.

## How it works

Postal code data is available as JSON at URLs like:

```
https://sanmai.github.io/pindx/json/AAA/AAABBB.json
```

Just replace `AAA` with the first three digits and `BBB` with the last three.

<span id="example-json">For example: [postal code 199151](https://sanmai.github.io/pindx/json/199/199151.json)</span>

<script src="{{ site.url }}{{ site.baseurl }}/assets/js/pindx.js"></script>

CORS enabled - call it directly from your web app. Perfect for address validation, shipping calculators, or location services.

Note: The source database link may not be accessible outside Russia. The API itself works where GitHub Pages work.

[Feel free to open an issue if anything is wrong or odd.](https://github.com/sanmai/pindx/issues/new)

### Response Fields

| Field | Description |
| ---- | ---- |
| Index | The postal code |
| OPSName | Post office name |
| OPSType | Office type (О = office, ММПО = mail processing center, etc.) |
| OPSSubm | Parent office postal code |
| Region | Region, territory, or republic |
| Autonom | Autonomous region (if any) |
| Area | District name |
| City | City or town name |
| City1 | Sub-settlement (if any) |
| ActDate | Last updated (YYYYMMDD) |
| IndexOld | Legacy postal code |

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

### Advanced example with async/await

```javascript
async function getPostalOffice(postalCode) {
  const prefix = postalCode.substring(0, 3);
  const response = await fetch(`https://sanmai.github.io/pindx/json/${prefix}/${postalCode}.json`);

  if (response.status === 404) {
    return null; // Not found
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
    console.log('Not found');
  }
})();
```
