// Pulls the logged-in user's history from the database-backed API
// (api/get_health_data.php) instead of polling an ESP32 IP address.
async function loadHistory() {
    try {
        const res = await fetch('api/get_health_data.php');
        if (!res.ok) return;
        const data = await res.json();

        const ctx = document.getElementById('historyChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.dates,
                datasets: [
                    {
                        label: 'BPM',
                        data: data.bpm,
                        borderColor: '#139f54',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.2
                    },
                    {
                        label: 'SpO2',
                        data: data.spo2,
                        borderColor: '#0B0C10',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.2
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: { title: { display: true, text: 'Date' } },
                    y: { title: { display: true, text: 'Value' } }
                }
            }
        });
    } catch (err) {
        console.error('Error loading health history:', err);
    }
}

document.addEventListener('DOMContentLoaded', loadHistory);
