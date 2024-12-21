// Fetch API to retrieve JSON data
fetch('../pages/about-us-data.json') // Path to your JSON file
.then(response => {
    if (!response.ok) {
        throw new Error('Network response was not OK');
    }
    return response.json(); // Parse the JSON response
})
.then(data => {
    // Populate Mission Section
    document.getElementById('mission-title').textContent = data.mission.title;
    document.getElementById('mission-desc').textContent = data.mission.description;

    // Populate Vision Section
    document.getElementById('vision-title').textContent = data.vision.title;
    document.getElementById('vision-desc').textContent = data.vision.description;

    // Populate Values Section
    document.getElementById('values-title').textContent = data.values.title;
    document.getElementById('values-desc').textContent = data.values.description;

    // Populate Team Section
    let teamContainer = document.getElementById('team-container');
    let teamHTML = '';

    data.team.forEach(member => {
        teamHTML += `
            <div class="team-member">
                <img src="../../${member.image}" alt="${member.name}">
                <h3>${member.name}</h3>
                <p>${member.role}</p>
            </div>
        `;
    });
    teamContainer.innerHTML = teamHTML;
})
.catch(error => {
    alert('Failed to load data. Please try again later.');
    console.error('Error fetching data:', error);
});