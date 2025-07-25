(async () => {
    try {
        // Dynamically determine the site's base URL (works for any GitHub Pages repo)
        const pathParts = window.location.pathname.split('/').filter(part => part);
        const repoBase = pathParts.length > 0 ? '/' + pathParts[0] : '';
        const baseUrl = window.location.origin + repoBase + '/json/';

        // Get a random prefix from the index
        const indexResponse = await fetch(baseUrl + 'index.json');
        const indexData = await indexResponse.json();
        const prefix = indexData[Math.floor(Math.random() * indexData.length)];

        // Get a random postal code from that prefix
        const prefixResponse = await fetch(baseUrl + prefix + '.json');
        const prefixData = await prefixResponse.json();
        const index = prefixData[Math.floor(Math.random() * prefixData.length)];

        const href = baseUrl + prefix + '/' + index + '.json';

        // Fetch the actual postal code data
        const dataResponse = await fetch(href);
        const json = await dataResponse.json();

        // Update the example JSON display
        const example = document.getElementById('example-json');
        if (example) {
            const pre = document.createElement("pre");
            pre.textContent = JSON.stringify(json, null, 2);
            example.appendChild(pre);

            const a = example.querySelector('a');
            if (a) {
                a.href = href;
                a.innerHTML = a.innerHTML.replace(/\d+/gi, index);
            }
        }

        // Update the fetch example with the real postal code
        const fetchExample = document.getElementById('fetch-example');
        if (fetchExample) {
            fetchExample.innerHTML = fetchExample.innerHTML.replace(/123456/g, index);
            fetchExample.innerHTML = fetchExample.innerHTML.replace(/123/g, prefix);
        }
    } catch (error) {
        console.error('Failed to load postal code example:', error);
    }
})();