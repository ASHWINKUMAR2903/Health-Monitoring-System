let chartInstance = null;

async function loadData() {
    const start = document.getElementById('start-date').value;
    const end = document.getElementById('end-date').value;

    const params = new URLSearchParams();
    if (start) params.set('start', start);
    if (end) params.set('end', end);

    try {
        const res = await fetch('api/get_health_data.php?' + params.toString());
        if (!res.ok) return;
        const data = await res.json();
        renderTable(data);
        renderChart(data);
    } catch (err) {
        console.error('Error fetching health data:', err);
    }
}

function renderTable(data) {
    const tableBody = document.getElementById('data-table-body');
    tableBody.innerHTML = '';

    data.dates.forEach((date, index) => {
        const row = `<tr>
            <td>${date}</td>
            <td>${data.bpm[index]}</td>
            <td>${data.spo2[index]}</td>
        </tr>`;
        tableBody.innerHTML += row;
    });
}

function renderChart(data) {
    const ctx = document.getElementById('healthChart').getContext('2d');
    if (chartInstance) {
        chartInstance.destroy();
    }
    chartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.dates,
            datasets: [
                {
                    label: 'BPM',
                    data: data.bpm,
                    borderColor: '#139f54',
                    borderWidth: 2,
                    fill: false
                },
                {
                    label: 'SpO2',
                    data: data.spo2,
                    borderColor: '#0B0C10',
                    borderWidth: 2,
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                x: { title: { display: true, text: 'Date' } },
                y: { title: { display: true, text: 'Values' } }
            }
        }
    });
}

// Load all available data on first page load
window.addEventListener('DOMContentLoaded', loadData);
