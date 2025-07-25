(async () => {
    // Dynamically determine the site's base URL
    const sitePath = window.location.pathname.replace(/\/en\/?$/, '').replace(/\/$/, '');
    const baseUrl = window.location.origin + sitePath + '/json/';

    // Get a random prefix from the index
    let prefix = await window.fetch(baseUrl + 'index.json')
        .then(function(response) {
            return response.json();
        }).then(function(json) {
            return json[~~(Math.random() * json.length)];
        });

    // Get a random postal code from that prefix
    let index = await window.fetch(baseUrl + prefix + '.json')
        .then(function(response) {
            return response.json();
        }).then(function(json) {
            return json[~~(Math.random() * json.length)];
        });

    let href = baseUrl + prefix + '/' + index + '.json';

    // Fetch the actual postal code data
    window.fetch(href)
        .then(function(response) {
            return response.json();
        }).then(function(json) {
            // Update the example JSON display
            let example = document.getElementById('example-json');
            if (example) {
                let pre = document.createElement("pre");
                pre.textContent = JSON.stringify(json, null, 2);
                example.appendChild(pre);

                let a = example.querySelector('a');
                if (a) {
                    a.href = href;
                    a.innerHTML = a.innerHTML.replace(/\d+/gi, index);
                }
            }

            // Update the fetch example with the real postal code
            let fetchExample = document.getElementById('fetch-example');
            if (fetchExample) {
                fetchExample.innerHTML = fetchExample.innerHTML.replace(/123456/g, index);
                fetchExample.innerHTML = fetchExample.innerHTML.replace(/123/g, prefix);
            }
        });
})();