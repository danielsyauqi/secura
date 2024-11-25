// public/js/team-management.js

function loadThreatDetails(threatGroup, threatId) {
    fetch(`/api/threat-details`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({
            threat_group: threatGroup,
            threat_id: threatId,
        })
    })
    .then(response => response.json())
    .then(data => {
        // Find the relevant Select field for threat_detail and update options
        const selectField = document.querySelector(`[name="asset_threat[${threatId}].threat_detail"]`);
        selectField.innerHTML = ''; // Clear existing options

        // Populate new options from the response
        for (const [value, label] of Object.entries(data.options)) {
            const option = document.createElement('option');
            option.value = value;
            option.textContent = label;
            selectField.appendChild(option);
        }
    })
    .catch(error => {
        console.error('Error fetching threat details:', error);
    });
}