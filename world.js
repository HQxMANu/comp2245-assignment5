document.addEventListener('DOMContentLoaded', () => {
    const lookupButton = document.getElementById('lookup');
    const lookupCitiesButton = document.getElementById('lookup-cities');
    const countryInput = document.getElementById('country');
    const resultDiv = document.getElementById('result');

    async function fetchData(query) {
        const url = `world.php?${query}`;
        try {
            const response = await fetch(url);
            const data = await response.text();
            resultDiv.innerHTML = data;
        } catch (error) {
            resultDiv.innerHTML = `<p>Could not fetch data. Please try again.</p>`;
        }
    }

    lookupButton.addEventListener('click', () => {
        const country = countryInput.value;
        fetchData(`country=${encodeURIComponent(country)}`);
    });

    lookupCitiesButton.addEventListener('click', () => {
        const country = countryInput.value;
        fetchData(`country=${encodeURIComponent(country)}&lookup=cities`);
    });
});

